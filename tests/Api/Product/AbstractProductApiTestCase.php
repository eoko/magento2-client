<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\tests\Api\Product;

use Eoko\Magento2\Client\tests\AbstractApiTestCase;

abstract class AbstractProductApiTestCase extends AbstractApiTestCase
{
    public function sanitizeProducts(array $products): array
    {
        return array_map(function ($product) {
            return $this->sanitizeProduct($product);
        }, $products);
    }

    public function sanitizeProduct(array $product): array
    {
        return array_intersect_key($product, array_flip(['sku', 'name', 'price', 'status', 'visibility', 'attribute_set_id']));
    }
}
