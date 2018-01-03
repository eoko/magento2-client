<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\Client;

use Eoko\Magento2\Client\Routing\UriGeneratorInterface;

/**
 * Generic client to execute common request on resources.
 */
class ResourceClient implements ResourceClientInterface
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var UriGeneratorInterface */
    protected $uriGenerator;

    /**
     * @param HttpClientInterface   $httpClient
     * @param UriGeneratorInterface $uriGenerator
     */
    public function __construct(
        HttpClientInterface $httpClient,
        UriGeneratorInterface $uriGenerator
    ) {
        $this->httpClient = $httpClient;
        $this->uriGenerator = $uriGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource($uri, array $uriParameters = [], array $queryParameters = []): array
    {
        $uri = $this->uriGenerator->generate($uri, $uriParameters, $queryParameters);

        $response = $this->httpClient->sendRequest('GET', $uri, ['Accept' => '*/*']);

        $response = (array) json_decode($response->getBody()->getContents(), true);

        /* @todo remove dirty patch */
        $response['_links'] = ['self' => ['href' => $uri]];

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getResources(
        $uri,
        array $uriParameters = [],
        array $queryParameters = []
    ): array {
        return $this->getResource($uri, $uriParameters, $queryParameters);
    }

    /**
     * {@inheritdoc}
     */
    public function createResource($uri, array $uriParameters = [], array $body = []): array
    {
        unset($body['_links']);

        $uri = $this->uriGenerator->generate($uri, $uriParameters);
        $response = $this->httpClient->sendRequest(
            'POST',
            $uri,
            ['Content-Type' => 'application/json'],
            json_encode($body)
        );

        return (array) json_decode($response->getBody()->getContents(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function updateResource($uri, array $uriParameters = [], array $body = []): array
    {
        unset($body['_links']);

        $uri = $this->uriGenerator->generate($uri, $uriParameters);

        $response = $this->httpClient->sendRequest(
            'PUT',
            $uri,
            ['Content-Type' => 'application/json'],
            json_encode($body)
        );

        return (array) json_decode($response->getBody()->getContents(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteResource($uri, array $uriParameters = [])
    {
        $uri = $this->uriGenerator->generate($uri, $uriParameters);

        $response = $this->httpClient->sendRequest('DELETE', $uri);

        return $response->getStatusCode();
    }
}
