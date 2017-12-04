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

/**
 * API to manage the authentication.
 */
interface AdminTokenApiInterface
{
    /**
     * Get an admin token.
     *
     * @param string $username
     * @param string $password
     *
     * @return string
     */
    public function getAdminToken(string $username, string $password): string;
}
