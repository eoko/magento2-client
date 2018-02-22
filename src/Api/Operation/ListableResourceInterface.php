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

use Eoko\Magento2\Client\Pagination\PageInterface;
use Eoko\Magento2\Client\Pagination\ResourceCursorInterface;
use Eoko\Magento2\Client\Search\SearchCriteria;

/**
 * API that can fetch a list of resources.
 */
interface ListableResourceInterface
{
    /**
     * Gets a list of resources by returning the first page.
     * Consequently, this method does not return all the resources.
     *
     * @param SearchCriteria|null $searchCriteria
     *
     * @return PageInterface if the request failed
     */
    public function listPerPage(?SearchCriteria $searchCriteria): PageInterface;

    /**
     * Gets a cursor to iterate over a list of resources.
     *
     * @param int                 $limit          The limit of returning values. Do note that the server has a maximum limit allowed.
     * @param SearchCriteria|null $searchCriteria
     *
     * @return ResourceCursorInterface
     */
    public function all($limit = 100, ?SearchCriteria $searchCriteria): ResourceCursorInterface;
}
