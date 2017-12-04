<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\Api\Operation;

use Eoko\Magento2\Client\Exception\HttpException;

interface GettableResourceInterface
{
    /**
     * Gets a resource by its code.
     *
     * @param string $code Code of the resource
     *
     * @throws HttpException if the request failed
     *
     * @return array
     */
    public function get($code): array;
}
