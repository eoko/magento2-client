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

use Eoko\Magento2\Client\Pagination\PageInterface;
use Eoko\Magento2\Client\Pagination\ResourceCursorInterface;

class ListProductApiIntegration extends AbstractProductApiTestCase
{
    public function testListPerPage()
    {
        $api = $this->createClient()->getProductApi();
        $expectedProducts = $this->getExpectedProducts();
        $baseUri = $this->getConfiguration()['magento2']['base_uri'];

        $firstPage = $api->listPerPage();

        $this->assertInstanceOf(PageInterface::class, $firstPage);
        $this->assertNull($firstPage->getPreviousLink());
        $this->assertNull($firstPage->getPreviousPage());
        $this->assertFalse($firstPage->hasPreviousPage());
        $this->assertTrue($firstPage->hasNextPage());
        $this->assertSame($baseUri.'/V1/products?searchCriteria%5BpageSize%5D=25&searchCriteria%5BcurrentPage%5D=2', $firstPage->getNextLink());

        $firstPageProducts = $this->sanitizeProducts($firstPage->getItems());
        $firstPageExpectedProducts = array_slice($expectedProducts, 0, 25);

        $this->assertSameContent($firstPageExpectedProducts, $firstPageProducts);

        $secondPage = $firstPage->getNextPage();

        $this->assertInstanceOf(PageInterface::class, $secondPage);
        $this->assertTrue($secondPage->hasPreviousPage());
        $this->assertTrue($secondPage->hasNextPage());
        $this->assertSame($baseUri.'/V1/products?searchCriteria%5BpageSize%5D=25&searchCriteria%5BcurrentPage%5D=1', $secondPage->getPreviousLink());
        $this->assertSame($baseUri.'/V1/products?searchCriteria%5BpageSize%5D=25&searchCriteria%5BcurrentPage%5D=3', $secondPage->getNextLink());

        $secondPageProducts = $this->sanitizeProducts($secondPage->getItems());
        $secondPageExpectedProducts = array_slice($expectedProducts, 25, 25);

        $this->assertSameContent($secondPageExpectedProducts, $secondPageProducts);

        $nextPAge = $secondPage->getNextPage();
        $this->assertInstanceOf(PageInterface::class, $nextPAge);

        $lastPage = $secondPage->getLastPage();
        $this->assertInstanceOf(PageInterface::class, $lastPage);
        $this->assertTrue($lastPage->hasPreviousPage());
        $this->assertFalse($lastPage->hasNextPage());
        $this->assertNull($lastPage->getNextPage());
        $this->assertNull($lastPage->getNextLink());
        $this->assertSame($baseUri.'/V1/products?searchCriteria%5BpageSize%5D=25&searchCriteria%5BcurrentPage%5D=81', $lastPage->getPreviousLink());

        $products = $lastPage->getItems();
        $this->assertCount(21, $products);

        $previousPage = $lastPage->getPreviousPage();
        $this->assertInstanceOf(PageInterface::class, $previousPage);
    }

    public function testListPerPageWithSpecificQueryParameter()
    {
        $api = $this->createClient()->getProductApi();
        $expectedProducts = $this->getExpectedProducts();
        $baseUri = $this->getConfiguration()['magento2']['base_uri'];

        $firstPage = $api->listPerPage(['foo' => 'bar']);

        $this->assertInstanceOf(PageInterface::class, $firstPage);
        $this->assertNull($firstPage->getPreviousLink());
        $this->assertNull($firstPage->getPreviousPage());
        $this->assertFalse($firstPage->hasPreviousPage());
        $this->assertTrue($firstPage->hasNextPage());
        $this->assertSame($baseUri.'/V1/products?foo=bar&searchCriteria%5BpageSize%5D=25&searchCriteria%5BcurrentPage%5D=2', $firstPage->getNextLink());

        $firstPageProducts = $this->sanitizeProducts($firstPage->getItems());
        $firstPageExpectedProducts = array_slice($expectedProducts, 0, 25);
        $this->assertSameContent($firstPageExpectedProducts, $firstPageProducts);
    }

    public function testAll()
    {
        $api = $this->createClient()->getProductApi();
        $products = $api->all();

        $this->assertInstanceOf(ResourceCursorInterface::class, $products);

        $products = $api->all(13);

        $expectedProducts = array_slice($this->getExpectedProducts(), 0, 13);
        $products = $this->sanitizeProducts(iterator_to_array($products));

        $this->assertSameContent($expectedProducts, $products);
    }

    public function testAllWithUselessQueryParameter()
    {
        $api = $this->createClient()->getProductApi();
        $products = $api->all(10, ['foo' => 'bar']);

        $this->assertInstanceOf(ResourceCursorInterface::class, $products);

        $expectedProducts = array_slice($this->getExpectedProducts(), 0, 10);
        $products = $this->sanitizeProducts(iterator_to_array($products));

        $this->assertSameContent($expectedProducts, $products);
    }

    /**
     * @return array
     */
    protected function getExpectedProducts()
    {
        return [
            [
                'sku' => '24-MB01',
                'name' => 'Joust Duffle Bag',
                'price' => 34,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-MB04',
                'name' => 'Strive Shoulder Pack',
                'price' => 32,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-MB03',
                'name' => 'Crown Summit Backpack',
                'price' => 38,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-MB05',
                'name' => 'Wayfarer Messenger Bag',
                'price' => 45,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-MB06',
                'name' => 'Rival Field Messenger',
                'price' => 45,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-MB02',
                'name' => 'Fusion Backpack',
                'price' => 59,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-UB02',
                'name' => 'Impulse Duffle',
                'price' => 74,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WB01',
                'name' => 'Voyage Yoga Bag',
                'price' => 32,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WB02',
                'name' => 'Compete Track Tote',
                'price' => 32,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WB05',
                'name' => 'Savvy Shoulder Tote',
                'price' => 32,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WB06',
                'name' => 'Endeavor Daytrip Backpack',
                'price' => 33,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WB03',
                'name' => 'Driven Backpack',
                'price' => 36,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WB07',
                'name' => 'Overnight Duffle',
                'price' => 45,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WB04',
                'name' => 'Push It Messenger Bag',
                'price' => 45,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-UG06',
                'name' => 'Affirm Water Bottle ',
                'price' => 7,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-UG07',
                'name' => 'Dual Handle Cardio Ball',
                'price' => 12,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-UG04',
                'name' => 'Zing Jump Rope',
                'price' => 12,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-UG02',
                'name' => 'Pursuit Lumaflex&trade; Tone Band',
                'price' => 16,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-UG05',
                'name' => 'Go-Get\'r Pushup Grips',
                'price' => 19,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-UG01',
                'name' => 'Quest Lumaflex&trade; Band',
                'price' => 19,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WG084',
                'name' => 'Sprite Foam Yoga Brick',
                'price' => 5,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WG088',
                'name' => 'Sprite Foam Roller',
                'price' => 19,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-UG03',
                'name' => 'Harmony Lumaflex&trade; Strength Band Kit ',
                'price' => 22,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WG081-gray',
                'name' => 'Sprite Stasis Ball 55 cm',
                'price' => 23,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG081-pink',
                'name' => 'Sprite Stasis Ball 55 cm',
                'price' => 23,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG081-blue',
                'name' => 'Sprite Stasis Ball 55 cm',
                'price' => 23,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG082-gray',
                'name' => 'Sprite Stasis Ball 65 cm',
                'price' => 27,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG082-pink',
                'name' => 'Sprite Stasis Ball 65 cm',
                'price' => 27,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG082-blue',
                'name' => 'Sprite Stasis Ball 65 cm',
                'price' => 27,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG083-gray',
                'name' => 'Sprite Stasis Ball 75 cm',
                'price' => 32,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG083-pink',
                'name' => 'Sprite Stasis Ball 75 cm',
                'price' => 32,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG083-blue',
                'name' => 'Sprite Stasis Ball 75 cm',
                'price' => 32,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG085',
                'name' => 'Sprite Yoga Strap 6 foot',
                'price' => 14,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG086',
                'name' => 'Sprite Yoga Strap 8 foot',
                'price' => 17,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-WG087',
                'name' => 'Sprite Yoga Strap 10 foot',
                'price' => 21,
                'status' => 1,
                'visibility' => 1,
            ],
            [
                'sku' => '24-MG04',
                'name' => 'Aim Analog Watch',
                'price' => 45,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-MG01',
                'name' => 'Endurance Watch',
                'price' => 49,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-MG03',
                'name' => 'Summit Watch',
                'price' => 54,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-MG05',
                'name' => 'Cruise Dual Analog Watch',
                'price' => 55,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-MG02',
                'name' => 'Dash Digital Watch',
                'price' => 92,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WG09',
                'name' => 'Luma Analog Watch',
                'price' => 43,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WG01',
                'name' => 'Bolo Sport Watch',
                'price' => 49,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WG03',
                'name' => 'Clamber Watch',
                'price' => 54,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WG02',
                'name' => 'Didi Sport Watch',
                'price' => 92,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '24-WG080',
                'name' => 'Sprite Yoga Companion Kit',
                'price' => 0,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '240-LV04',
                'name' => 'Beginner\'s Yoga',
                'price' => 6,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '240-LV05',
                'name' => 'LifeLong Fitness IV',
                'price' => 14,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '240-LV06',
                'name' => 'Yoga Adventure',
                'price' => 22,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '240-LV07',
                'name' => 'Solo Power Circuit',
                'price' => 14,
                'status' => 1,
                'visibility' => 4,
            ],
            [
                'sku' => '240-LV08',
                'name' => 'Advanced Pilates & Yoga (Strength)',
                'price' => 18,
                'status' => 1,
                'visibility' => 4,
            ],
        ];
    }
}
