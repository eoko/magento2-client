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

/**
 * API that can "Update" a resource.
 */
interface UpdateblaInterface
{
    /**
     * Creates a resource if it does not exist yet, otherwise updates partially the resource.
     *
     * @param string $code code of the resource to create or update
     * @param array  $data data of the resource to create or update
     *
     * @return array if the request failed
     */
    public function update($code, array $data = []): array;
}
