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
use Eoko\Magento2\Client\Exception\InvalidArgumentException;

/**
 * API that can create a resource.
 */
interface CreatableResourceInterface
{
    /**
     * Creates a resource.
     *
     * @param string $code code of the resource to create
     * @param array  $data data of the resource to create
     *
     * @throws HttpException            if the request failed
     * @throws InvalidArgumentException if the parameter "code" is defined in the data parameter
     *
     * @return array
     */
    public function create($code, array $data = []): array;
}
