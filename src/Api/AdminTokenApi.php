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

use Eoko\Magento2\Client\Client\ResourceClient;

/**
 * API implementation to manage the authentication.
 */
class AdminTokenApi implements AdminTokenApiInterface
{
    const TOKEN_URI = 'V1/integration/admin/token';

    /** @var ResourceClient */
    private $resourceClient;

    /**
     * @param ResourceClient $resourceClient
     */
    public function __construct(ResourceClient $resourceClient)
    {
        $this->resourceClient = $resourceClient;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminToken(string $username, string $password): string
    {
        $requestBody = [
            'username' => $username,
            'password' => $password,
        ];

        $result = $this->resourceClient->createResource(static::TOKEN_URI, [], $requestBody);

        return array_pop($result);
    }
}
