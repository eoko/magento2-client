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

class UpdateStockItemApiIntegration extends AbstractProductApiTestCase
{
    public function testUpdate()
    {
        $productApi = $this->createClient()->getProductApi();
        $api = $this->createClient()->getProductApi()->getStockItemApi('MH03-M-Blue');

        $item = $productApi->get('MH03-M-Blue')['extension_attributes']['stock_item'];

        // There is nothing interesting in response...
        $api->update($item['item_id'], ['qty' => 42]);

        $expected = $this->sanitizeStockItem($productApi->get('MH03-M-Blue')['extension_attributes']['stock_item']);

        $this->assertSameContent(['qty' => 42], $expected);
    }

    public function sanitizeStockItem(array $product): array
    {
        return array_intersect_key($product, array_flip(['qty']));
    }
}
