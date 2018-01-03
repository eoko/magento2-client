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

class StockItemApi implements StockItemApiInterface
{
    const PRODUCT_STOCK_ITEMS_URI = 'V1/products/%s/stockItems/%s';

    /** @var ResourceClientInterface */
    protected $resourceClient;

    /** @var string */
    protected $productSku;

    /**
     * @param ResourceClientInterface $resourceClient
     * @param string                  $productSku
     */
    public function __construct(ResourceClientInterface $resourceClient, string $productSku)
    {
        $this->resourceClient = $resourceClient;
        $this->productSku = $productSku;
    }

    /**
     * {@inheritdoc}
     */
    public function update($stockItemId, array $data = []): array
    {
        return $this->resourceClient->updateResource(static::PRODUCT_STOCK_ITEMS_URI, [$this->productSku, $stockItemId], ['stock_item' => $data]);
    }
}
