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
use Eoko\Magento2\Client\Search\SearchCriteria;

class ProductApi implements ProductApiInterface
{
    const PRODUCTS_URI = 'V1/products';
    const PRODUCT_URI = 'V1/products/%s';

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

    public function getStockItemApi(string $productSku): StockItemApiInterface
    {
        return new StockItemApi($this->resourceClient, $productSku);
    }

    /**
     * {@inheritdoc}
     */
    public function get($sku): array
    {
        return $this->resourceClient->getResource(static::PRODUCT_URI, [$sku]);
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

        $data = $this->resourceClient->getResources(static::PRODUCTS_URI, [], $queryParameters);

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
    public function create($sku, array $data = []): array
    {
        if (array_key_exists('sku', $data)) {
            throw new InvalidArgumentException('The parameter "sku" should not be defined in the data parameter');
        }

        $data['sku'] = $sku;

        return $this->resourceClient->createResource(static::PRODUCTS_URI, [], ['product' => $data]);
    }

    /**
     * {@inheritdoc}
     */
    public function update($sku, array $data = []): array
    {
        return $this->resourceClient->updateResource(static::PRODUCT_URI, [$sku], ['product' => $data]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($sku)
    {
        return $this->resourceClient->deleteResource(static::PRODUCT_URI, [$sku]);
    }
}
