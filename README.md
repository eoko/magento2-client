# Eoko/magento2-client

[![Build Status](https://travis-ci.org/eoko/magento2-client.svg?branch=master)](https://travis-ci.org/eoko/magento2-client)

A simple PHP client to use the [Magento2](https://github.com/magento/magento2).

## Requirements

* PHP >= 7.1
* Composer

## Installation

We use HTTPPlug as the HTTP client abstraction layer.
In this example, we will use [Guzzle](https://github.com/guzzle/guzzle) v6 as the HTTP client implementation.

`eoko/magento2-client` uses [Composer](http://getcomposer.org).
The first step to use `eoko/magento2-client` is to download composer:

```bash
$ curl -s http://getcomposer.org/installer | php
```

Then, run the following command to require the library:
```bash
$ php composer.phar require eoko/magento2-client php-http/guzzle6-adapter
```

If you want to use another HTTP client implementation, you can check [here](https://packagist.org/providers/php-http/client-implementation) the full list of HTTP client implementations.

## Getting started

### Initialise the client
You first need to initialise the client with your credentials with admin token.

If you don't have any admin token, you can create it and retrieve with the following code :

 ```php
<?php

require('./../vendor/autoload.php');

use Eoko\Magento2\Client\MagentoClientBuilder;
use Eoko\Magento2\Client\Security\AdminAuthentication;

// We initiate the client builder
$clientBuilder = new MagentoClientBuilder('http://m2.localhost:8000/rest/default');

// Create an unauthenticated client
$unAuthenticatedClient = $clientBuilder->buildAuthenticatedClient();

 // Get an admin token
echo $unAuthenticatedClient->getAdminTokenApi()->getAdminToken('magento2', 'magento2');
 ```

After that, you can create an authenticated client :

```php
<?php
require('./../vendor/autoload.php');

use Eoko\Magento2\Client\MagentoClientBuilder;
use Eoko\Magento2\Client\Security\AdminAuthentication;

$token = 'youtoken...';

// Authentication from admin token
$authentication = AdminAuthentication::fromAdminToken($token);

// Create an authenticated client
$authenticatedClient = $clientBuilder->buildAuthenticatedClient($authentication);

```

### Get a product

```php
$product = $client->getProductApi()->get('top');
echo $product['sku']; // display "top"
```

### Get a list of products

#### By getting pages

```php
$firstPage = $client->getProductApi()->listPerPage();

echo $page->getCount();

foreach ($page->getItems() as $product) {
    // do your stuff here
    echo $product['identifier'];
}

$nextPage = $page->getNextPage();

$firstPage = $nextPage->getPreviousPage();
```

#### By getting a cursor

```php
$products = $client->getProductApi()->all(50);
foreach ($products as $product) {
    // do your stuff here
    echo $product['sku'];
}
```

### Create a product

> unsupported

### Update a product

```php
$client->getProductApi()->update('top', ['family' => 'tshirt']);
```

## Stock Item

### Update a stock item

```
$api = $client->getProductApi()->getStockItemApi('MH03-M-Blue');

// There is nothing interesting in the output (product id :/)
$api->update($item['item_id'], ['qty' => 42]);
```
## Support

If you find a bug or want to submit an improvement, don't hesitate to raise an issue on Github.