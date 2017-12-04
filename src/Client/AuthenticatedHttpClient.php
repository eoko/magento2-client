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

use Eoko\Magento2\Client\Api\AuthenticationApiInterface;
use Eoko\Magento2\Client\Security\AuthenticationInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Http client to send an authenticated request.
 *
 * The authentication process is automatically handle by this client implementation.
 *
 * It enriches the request with an access token.
 * If the access token is expired, it will automatically refresh it.
 */
class AuthenticatedHttpClient implements HttpClientInterface
{
    /** @var HttpClient */
    protected $basicHttpClient;

    /** @var AuthenticationApiInterface */
    protected $authenticationApi;

    /** @var AuthenticationInterface */
    protected $authentication;

    /**
     * @param HttpClient                 $basicHttpClient
     * @param AuthenticationApiInterface $authenticationApi
     * @param AuthenticationInterface    $authentication
     */
    public function __construct(
        HttpClient $basicHttpClient,
        AuthenticationApiInterface $authenticationApi = null,
        AuthenticationInterface $authentication
    ) {
        $this->basicHttpClient = $basicHttpClient;
        $this->authenticationApi = $authenticationApi;
        $this->authentication = $authentication;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest($httpMethod, $uri, array $headers = [], $body = null): ResponseInterface
    {
        $headers['Authorization'] = sprintf('Bearer %s', $this->authentication->getAccessToken());

        return $this->basicHttpClient->sendRequest($httpMethod, $uri, $headers, $body);
    }
}
