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

class UpdateProductApiIntegration extends AbstractProductApiTestCase
{
    public function testUpdate()
    {
        $api = $this->createClient()->getProductApi();

        $response = $this->sanitizeProduct($api->update('MH03-M-Blue', ['price' => 42]));
        $product = $this->sanitizeProduct($api->get('MH03-M-Blue'));

        $this->assertSameContent($response, $product);
    }
}
