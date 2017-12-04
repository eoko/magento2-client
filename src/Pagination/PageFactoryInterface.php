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
 * Factory interface to create a page object representing a list of resources.
 */
interface PageFactoryInterface
{
    /**
     * Creates a page object from body.
     *
     * @param array $data body of the response
     *
     * @return PageInterface
     */
    public function createPage(array $data): PageInterface;
}
