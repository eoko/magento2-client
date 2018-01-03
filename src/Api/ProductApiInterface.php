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

use Eoko\Magento2\Client\Api\Operation\CreatableResourceInterface;
use Eoko\Magento2\Client\Api\Operation\DeletableResourceInterface;
use Eoko\Magento2\Client\Api\Operation\GettableResourceInterface;
use Eoko\Magento2\Client\Api\Operation\ListableResourceInterface;
use Eoko\Magento2\Client\Api\Operation\UpdateblaInterface;

interface ProductApiInterface extends ListableResourceInterface, GettableResourceInterface, CreatableResourceInterface, UpdateblaInterface, DeletableResourceInterface
{
    /**
     * @param string $productSku
     *
     * @return StockItemApiInterface
     */
    public function getStockItemApi(string $productSku): StockItemApiInterface;
}
