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
use Eoko\Magento2\Client\Pagination\PageFactoryInterface;
use Eoko\Magento2\Client\Pagination\PageInterface;
use Eoko\Magento2\Client\Pagination\ResourceCursorFactoryInterface;
use Eoko\Magento2\Client\Pagination\ResourceCursorInterface;
use Eoko\Magento2\Client\Search\SearchCriteria;

class OrderApi implements OrderApiInterface
{
    const ORDERS_URI = 'V1/orders';
    const ORDER_URI = 'V1/orders/%s';

    /** @var ResourceClientInterface */
    protected $resourceClient;

    /** @var PageFactoryInterface */
    protected $pageFactory;

    /** @var ResourceCursorFactoryInterface */
    protected $cursorFactory;

    /**
     * @param ResourceClientInterface        $resourceClient
     * @param PageFactoryInterface           $pageFactory
     * @param ResourceCursorFactoryInterface $cursorFactory
     */
    public function __construct(
        ResourceClientInterface $resourceClient,
        PageFactoryInterface $pageFactory,
        ResourceCursorFactoryInterface $cursorFactory
    ) {
        $this->resourceClient = $resourceClient;
        $this->pageFactory = $pageFactory;
        $this->cursorFactory = $cursorFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function listPerPage(?SearchCriteria $searchCriteria): PageInterface
    {
        if (null === $searchCriteria) {
            $searchCriteria = new SearchCriteria();
        }

        $queryParameters['searchCriteria'] = $searchCriteria->toArray();

        $data = $this->resourceClient->getResources(static::ORDERS_URI, [], $queryParameters);

        return $this->pageFactory->createPage($data);
    }

    /**
     * {@inheritdoc}
     */
    public function all($limit = 100, ?SearchCriteria $searchCriteria): ResourceCursorInterface
    {
        $firstPage = $this->listPerPage($searchCriteria);

        return $this->cursorFactory->createCursor($limit, $firstPage);
    }

    /**
     * {@inheritdoc}
     */
    public function get($orderId): array
    {
        return $this->resourceClient->getResource(static::ORDER_URI, [$orderId]);
    }
}
