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

class CreateProductApiIntegration extends AbstractProductApiTestCase
{
    public function testCreateAnExistingProduct()
    {
        $api = $this->createClient()->getProductApi();
        $response = $api->create('MH03-M-Blue', [
            'attribute_set_id' => 4,
            'name' => 'Bruno Compete Hoodie-M-Blue',
            'price' => 63,
            'status' => 1,
            'visibility' => 1,
        ]);

        $this->assertSameContent($this->sanitizeProduct($response), [
            'sku' => 'MH03-M-Blue',
            'attribute_set_id' => 4,
            'name' => 'Bruno Compete Hoodie-M-Blue',
            'price' => 63,
            'status' => 1,
            'visibility' => 1,
        ]);
    }

    public function testCreate()
    {
        $api = $this->createClient()->getProductApi();
        $response = $api->create('foo', [
            'attribute_set_id' => 4,
            'name' => 'Bar',
            'price' => 42,
            'status' => 1,
            'visibility' => 0,
        ]);

        $expectedProduct = $this->sanitizeProduct($response);

        $product = $this->sanitizeProduct($api->get('foo'));

        $this->assertSameContent($expectedProduct, $product);
    }
}
