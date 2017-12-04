<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\Api;

interface AuthenticationApiInterface
{
    /**
     * Authenticates with the password grant type.
     *
     * @param string $clientId
     * @param string $secret
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function authenticateByPassword($clientId, $secret, $username, $password): array;

    /**
     * Authenticates with the refresh token grant type.
     *
     * @param string $clientId
     * @param string $secret
     * @param string $refreshToken
     *
     * @return array
     */
    public function authenticateByRefreshToken($clientId, $secret, $refreshToken): array;
}
