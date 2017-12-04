<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 * @project   Synczila
 */

namespace Eoko\Magento2\Client\Search;

/**
 * Class SearchCriteria.
 */
class SearchCriteria
{
    /** @var int */
    protected $pageSize = 10;

    /** @var int */
    protected $currentPage = 1;

    /**
     * @param int $pageSize
     */
    public function setPageSize(int $pageSize)
    {
        $this->pageSize = $pageSize;
    }

    /**
     * @param int $currentPage
     */
    public function setCurrentPage(int $currentPage)
    {
        $this->currentPage = $currentPage;
    }

    public function toArray()
    {
        return [
            'pageSize' => $this->pageSize,
            'currentPage' => $this->currentPage,
        ];
    }
}
