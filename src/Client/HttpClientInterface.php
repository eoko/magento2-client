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

use Eoko\Magento2\Client\Exception\HttpException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * Http client interface aims to send a request.
 */
interface HttpClientInterface
{
    /**
     * Sends a request.
     *
     * @param string              $httpMethod HTTP method to use
     * @param string|UriInterface $uri        URI of the request
     * @param array               $headers    headers of the request
     * @param string|null         $body       body of the request
     *
     * @throws HttpException if the request failed
     *
     * @return ResponseInterface
     */
    public function sendRequest($httpMethod, $uri, array $headers = [], $body = null): ResponseInterface;
}
