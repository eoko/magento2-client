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

class SearchGroup
{
    /** @var SearchItem[] */
    protected $items = [];

    /**
     * @return SearchItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param SearchItem[] $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param SearchItem $item
     */
    public function addItem(SearchItem $item)
    {
        $this->items[] = $item;
    }

    public function toArray()
    {
        $array = [];

        foreach ($this->items as $item) {
            $array[] = $item->toArray();
        }

        return $array;
    }
}
