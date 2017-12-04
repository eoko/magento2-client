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

class GetProductApiIntegration extends AbstractProductApiTestCase
{
    public function testGet()
    {
        $api = $this->createClient()->getProductApi();
        $product = $api->get('MH03-M-Blue');

        $this->assertSameContent($this->sanitizeProduct($product), [
            'sku' => 'MH03-M-Blue',
            'name' => 'Bruno Compete Hoodie-M-Blue',
            'price' => 63,
            'status' => 1,
            'visibility' => 1,
            'attribute_set_id' => 4,
        ]);
    }
}
