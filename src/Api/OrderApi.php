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

use Eoko\Magento2\Client\Client\ResourceClientInterface;
use Eoko\Magento2\Client\Exception\InvalidArgumentException;
use Eoko\Magento2\Client\Pagination\PageFactoryInterface;
use Eoko\Magento2\Client\Pagination\PageInterface;
use Eoko\Magento2\Client\Pagination\ResourceCursorFactoryInterface;
use Eoko\Magento2\Client\Pagination\ResourceCursorInterface;

class OrderApi implements OrderApiInterface
{
    const ORDER_URI = 'V1/orders/%s';

    /** @var ResourceClientInterface */
    protected $resourceClient;

    /**
     * @param ResourceClientInterface        $resourceClient
     */
    public function __construct(
        ResourceClientInterface $resourceClient
    ) {
        $this->resourceClient = $resourceClient;
    }

    /**
     * {@inheritdoc}
     */
    public function get($orderId): array
    {
        return $this->resourceClient->getResource(static::ORDER_URI, [$orderId]);
    }
}
