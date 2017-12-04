<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\Pagination;

/**
 * Factory interface to create a resource cursor object to iterate over a list of resources.
 */
interface ResourceCursorFactoryInterface
{
    /**
     * Creates a cursor from the first page of resources.
     *
     * @param int           $limit
     * @param PageInterface $firstPage
     *
     * @return ResourceCursorInterface
     */
    public function createCursor($limit, PageInterface $firstPage);
}
