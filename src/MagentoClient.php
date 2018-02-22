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
use Eoko\Magento2\Client\Security\Authentication;
use Eoko\Magento2\Client\Security\AuthenticationInterface;

/**
 * This class is the implementation of the client to use the Magento API.
 */
class MagentoClient implements MagentoClientInterface
{
    /** @var Authentication */
    protected $authentication;

    /** @var ProductApiInterface */
    protected $productApi;

    /** @var OrderApiInterface */
    protected $orderApi;

    /** @var AdminTokenApiInterface */
    private $adminTokenApi;

    /**
     * @param AuthenticationInterface|null $authentication
     * @param AdminTokenApiInterface       $adminTokenApi
     * @param ProductApiInterface          $productApi
     * @param OrderApiInterface            $orderApi
     */
    public function __construct(
        AuthenticationInterface $authentication = null,
        AdminTokenApiInterface $adminTokenApi,
        ProductApiInterface $productApi,
        OrderApiInterface $orderApi
    ) {
        $this->authentication = $authentication;
        $this->adminTokenApi = $adminTokenApi;
        $this->productApi = $productApi;
        $this->orderApi = $orderApi;
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        return $this->authentication->getAccessToken();
    }

    /**
     * {@inheritdoc}
     */
    public function getRefreshToken()
    {
        return $this->authentication->getRefreshToken();
    }

    /**
     * {@inheritdoc}
     */
    public function getProductApi(): ProductApiInterface
    {
        return $this->productApi;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderApi(): OrderApiInterface
    {
        return $this->orderApi;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminTokenApi(): AdminTokenApiInterface
    {
        return $this->adminTokenApi;
    }
}
