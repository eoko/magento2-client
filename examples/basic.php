<?php

require('./../vendor/autoload.php');

use Eoko\Magento2\Client\MagentoClientBuilder;
use Eoko\Magento2\Client\Security\AdminAuthentication;

// We initiate the client builder
$clientBuilder = new MagentoClientBuilder('http://m2.localhost:8000/rest/default');

// Create an unauthenticated client
$unAuthenticatedClient = $clientBuilder->buildAuthenticatedClient();

// Get an admin token
$token = $unAuthenticatedClient->getAdminTokenApi()->getAdminToken('magento2', 'magento2');

// Authentication from admin token
$authentication = AdminAuthentication::fromAdminToken($token);

// Create an authenticated client
$authenticatedClient = $clientBuilder->buildAuthenticatedClient($authentication);

// Retrieve the 10 first product
$productsCursor = $authenticatedClient->getProductApi()->all(10);

foreach ($productsCursor as $product) {
    echo 'We found the following product : ' . $product['sku'] . "\n";
}