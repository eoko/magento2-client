<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\Security;

/**
 * Credential data to authenticate to the API.
 */
class AdminAuthentication implements AuthenticationInterface
{
    /** @var string */
    protected $adminToken;

    protected function __construct()
    {
    }

    /**
     * @param string $adminToken
     *
     * @return AdminAuthentication
     */
    public static function fromAdminToken(string $adminToken)
    {
        $authentication = new static();
        $authentication->adminToken = $adminToken;

        return $authentication;
    }

    /**
     * @return null|string
     */
    public function getAccessToken(): ?string
    {
        return $this->adminToken;
    }
}
