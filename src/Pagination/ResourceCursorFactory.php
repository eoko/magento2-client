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
 * Class ResourceCursorFactory.
 */
class ResourceCursorFactory implements ResourceCursorFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function createCursor($limit, PageInterface $firstPage)
    {
        return new ResourceCursor($limit, $firstPage);
    }
}
