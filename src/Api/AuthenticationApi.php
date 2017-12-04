<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 * @project   Synczila
 */

namespace Eoko\Magento2\Client\Api;

use Eoko\Magento2\Client\Client\HttpClient;
use Eoko\Magento2\Client\Routing\UriGeneratorInterface;

class AuthenticationApi implements AuthenticationApiInterface
{
    const TOKEN_URI = 'api/oauth/v1/token';

    /** @var HttpClient */
    protected $httpClient;

    /** @var UriGeneratorInterface */
    protected $uriGenerator;

    /**
     * @param HttpClient            $httpClient
     * @param UriGeneratorInterface $uriGenerator
     */
    public function __construct(HttpClient $httpClient, UriGeneratorInterface $uriGenerator)
    {
        $this->httpClient = $httpClient;
        $this->uriGenerator = $uriGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateByPassword($clientId, $secret, $username, $password): array
    {
        $requestBody = [
            'grant_type' => 'password',
            'username' => $username,
            'password' => $password,
        ];

        return $this->authenticate($clientId, $secret, $requestBody);
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateByRefreshToken($clientId, $secret, $refreshToken): array
    {
        $requestBody = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ];

        return $this->authenticate($clientId, $secret, $requestBody);
    }

    /**
     * Authenticates the client by requesting the access token and the refresh token.
     *
     * @param string $clientId    client id
     * @param string $secret      secret associated to the client id
     * @param array  $requestBody body of the request to authenticate
     *
     * @return array returns the body of the response containing access token and refresh token
     */
    protected function authenticate($clientId, $secret, array $requestBody)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => sprintf('Basic %s', base64_encode($clientId.':'.$secret)),
        ];

        $uri = $this->uriGenerator->generate(static::TOKEN_URI);

        $response = $this->httpClient->sendRequest('POST', $uri, $headers, json_encode($requestBody));

        $responseBody = json_decode($response->getBody()->getContents(), true);

        return $responseBody;
    }
}
