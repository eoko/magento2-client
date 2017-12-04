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

use Eoko\Magento2\Client\Security\Authentication;
use Psr\Http\Message\ResponseInterface;

/**
 * Http client to send an authenticated request.
 *
 * The authentication process is automatically handle by this client implementation.
 *
 * It enriches the request with an access token.
 * If the access token is expired, it will automatically refresh it.
 */
class UnauthenticatedHttpClient implements HttpClientInterface
{
    /** @var HttpClient */
    protected $basicHttpClient;

    /**
     * @param HttpClient $basicHttpClient
     */
    public function __construct(
        HttpClient $basicHttpClient
    ) {
        $this->basicHttpClient = $basicHttpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function sendRequest($httpMethod, $uri, array $headers = [], $body = null): ResponseInterface
    {
        return $this->basicHttpClient->sendRequest($httpMethod, $uri, $headers, $body);
    }
}
