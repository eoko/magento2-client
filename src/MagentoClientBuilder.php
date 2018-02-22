<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client;

use Eoko\Magento2\Client\Api\AdminTokenApi;
use Eoko\Magento2\Client\Api\AuthenticationApi;
use Eoko\Magento2\Client\Api\OrderApi;
use Eoko\Magento2\Client\Api\ProductApi;
use Eoko\Magento2\Client\Client\AuthenticatedHttpClient;
use Eoko\Magento2\Client\Client\HttpClient;
use Eoko\Magento2\Client\Client\ResourceClient;
use Eoko\Magento2\Client\Client\UnauthenticatedHttpClient;
use Eoko\Magento2\Client\Pagination\PageFactory;
use Eoko\Magento2\Client\Pagination\ResourceCursorFactory;
use Eoko\Magento2\Client\Routing\UriGenerator;
use Eoko\Magento2\Client\Security\Authentication;
use Eoko\Magento2\Client\Security\AuthenticationInterface;
use Http\Client\HttpClient as Client;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;

/**
 * Builder of the class MagentoClient.
 * This builder is in charge to instantiate and inject the dependencies.
 */
class MagentoClientBuilder
{
    /** @var string */
    protected $baseUri;

    /** @var Client */
    protected $httpClient;

    /** @var RequestFactory */
    protected $requestFactory;

    /**
     * @param string $baseUri Base uri to request the API
     */
    public function __construct($baseUri)
    {
        $this->baseUri = $baseUri;
    }

    /**
     * Allows to directly set a client instead of using HttpClientDiscovery::find().
     *
     * @param Client $httpClient
     *
     * @return MagentoClientBuilder
     */
    public function setHttpClient(Client $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     * Allows to directly set a request factory instead of using MessageFactoryDiscovery::find().
     *
     * @param RequestFactory $requestFactory
     *
     * @return MagentoClientBuilder
     */
    public function setRequestFactory($requestFactory)
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    /**
     * Build the Magento client authenticated by user name and password.
     *
     * @param string $clientId Client id to use for the authentication
     * @param string $secret   Secret associated to the client
     * @param string $username Username to use for the authentication
     * @param string $password Password associated to the username
     *
     * @return MagentoClientInterface
     */
    public function buildAuthenticatedByPassword($clientId, $secret, $username, $password)
    {
        $authentication = Authentication::fromPassword($clientId, $secret, $username, $password);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * Build the Magento client authenticated by token.
     *
     * @param string $clientId     Client id to use for the authentication
     * @param string $secret       Secret associated to the client
     * @param string $token        Token to use for the authentication
     * @param string $refreshToken Token to use to refresh the access token
     *
     * @return MagentoClientInterface
     */
    public function buildAuthenticatedByToken($clientId, $secret, $token, $refreshToken)
    {
        $authentication = Authentication::fromToken($clientId, $secret, $token, $refreshToken);

        return $this->buildAuthenticatedClient($authentication);
    }

    /**
     * @param AuthenticationInterface $authentication
     *
     * @return MagentoClientInterface
     */
    public function buildAuthenticatedClient(AuthenticationInterface $authentication = null)
    {
        list($resourceClient, $pageFactory, $cursorFactory) = $this->setUp($authentication);

        $client = new MagentoClient(
            $authentication,
            new AdminTokenApi($resourceClient),
            new ProductApi($resourceClient, $pageFactory, $cursorFactory),
            new OrderApi($resourceClient, $pageFactory, $cursorFactory)
        );

        return $client;
    }

    /**
     * @param AuthenticationInterface|null $authentication
     *
     * @return array
     */
    protected function setUp(AuthenticationInterface $authentication = null)
    {
        $uriGenerator = new UriGenerator($this->baseUri);

        $client = new HttpClient($this->getHttpClient(), $this->getRequestFactory());

        if (is_null($authentication)) {
            $httpClient = new UnauthenticatedHttpClient($client);
        } else {
            $authenticationApi = new AuthenticationApi($client, $uriGenerator);
            $httpClient = new AuthenticatedHttpClient($client, $authenticationApi, $authentication);
        }

        $resourceClient = new ResourceClient(
            $httpClient,
            $uriGenerator
        );

        $pageFactory = new PageFactory($httpClient);
        $cursorFactory = new ResourceCursorFactory();

        return [$resourceClient, $pageFactory, $cursorFactory];
    }

    /**
     * @return Client
     */
    private function getHttpClient()
    {
        if (null === $this->httpClient) {
            $this->httpClient = HttpClientDiscovery::find();
        }

        return $this->httpClient;
    }

    /**
     * @return RequestFactory
     */
    private function getRequestFactory()
    {
        if (null === $this->requestFactory) {
            $this->requestFactory = MessageFactoryDiscovery::find();
        }

        return $this->requestFactory;
    }
}
