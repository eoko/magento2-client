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
 * Cursor interface  iterate over a list of resources.
 */
interface ResourceCursorInterface extends \Iterator
{
    /**
     * Get the number of resources per page.
     *
     * @return int
     */
    public function getLimit();
}
