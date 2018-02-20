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

use Eoko\Magento2\Client\Api\AdminTokenApiInterface;
use Eoko\Magento2\Client\Api\OrderApiInterface;
use Eoko\Magento2\Client\Api\ProductApiInterface;

/**
 * Client to use the Magento API.
 */
interface MagentoClientInterface
{
    /**
     * Gets the authentication access token.
     *
     * @return null|string
     */
    public function getToken();

    /**
     * Gets the authentication refresh token.
     *
     * @return null|string
     */
    public function getRefreshToken();

    /**
     * Gets the product API.
     *
     * @return ProductApiInterface
     */
    public function getProductApi(): ProductApiInterface;

    /**
     * Gets the Order API.
     *
     * @return OrderApiInterface
     */
    public function getOrderApi(): OrderApiInterface;

    /**
     *  Gets the admin token API.
     *
     * @return AdminTokenApiInterface
     */
    public function getAdminTokenApi(): AdminTokenApiInterface;
}
