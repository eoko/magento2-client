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

use HttpException;

/**
 * API that can delete a resource.
 */
interface DeletableResourceInterface
{
    /**
     * Deletes a resource.
     *
     * @param string $code code of the resource to delete
     *
     * @throws HttpException
     *
     * @return int status code 204 indicating that the resource has been well deleted
     */
    public function delete($code);
}
