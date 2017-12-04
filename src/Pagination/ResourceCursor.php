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
 * Cursor to iterate over a list of resources.
 */
class ResourceCursor implements ResourceCursorInterface
{
    /** @var PageInterface */
    protected $currentPage;

    /** @var PageInterface */
    protected $firstPage;

    /** @var int */
    protected $limit;

    /** @var int */
    protected $currentIndex = 0;

    /** @var int */
    protected $totalIndex = 0;

    /**
     * @param int           $limit
     * @param PageInterface $firstPage
     */
    public function __construct($limit = null, PageInterface $firstPage)
    {
        $this->firstPage = $firstPage;
        $this->currentPage = $firstPage;
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->currentPage->getItems()[$this->currentIndex];
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        ++$this->currentIndex;
        ++$this->totalIndex;

        $items = $this->currentPage->getItems();

        if (!isset($items[$this->currentIndex]) && $this->currentPage->hasNextPage()) {
            $this->currentIndex = 0;
            $this->currentPage = $this->currentPage->getNextPage();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->totalIndex;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->totalIndex < $this->limit && isset($this->currentPage->getItems()[$this->currentIndex]);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->totalIndex = 0;
        $this->currentIndex = 0;
        $this->currentPage = $this->firstPage;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->limit;
    }
}
