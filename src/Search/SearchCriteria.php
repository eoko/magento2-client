<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
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

    /** @var SearchGroup[] */
    protected $searchGroups = [];

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

    /**
     * @return SearchGroup[]
     */
    public function getSearchGroups(): array
    {
        return $this->searchGroups;
    }

    /**
     * @param SearchGroup[] $searchGroups
     */
    public function setSearchGroups(array $searchGroups)
    {
        $this->searchGroups = $searchGroups;
    }

    /**
     * @param SearchGroup $searchGroup
     */
    public function addSearchGroup(SearchGroup $searchGroup)
    {
        $this->searchGroups[] = $searchGroup;
    }

    /**
     * @return int
     */
    public function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [
            'pageSize' => $this->pageSize,
            'currentPage' => $this->currentPage,
            'filter_groups' => [],
        ];

        foreach ($this->searchGroups as $searchGroup) {
            $array['filter_groups'][] = $searchGroup->toArray();
        }

        return $array;
    }
}
