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
 * Page interface represents a list of paginated resources.
 */
interface PageInterface
{
    /**
     * Returns the last page of the list of resources.
     *
     * @return mixed
     */
    public function getLastPage(): self;

    /**
     * Returns the first page of the list of resources.
     *
     * @return PageInterface
     */
    public function getFirstPage(): self;

    /**
     * Returns the previous page of the list of resources if it exists, null otherwise.
     *
     * @return PageInterface|null
     */
    public function getPreviousPage(): ?self;

    /**
     * Returns the previous page of the list of resources if it exists, null otherwise.
     *
     * @return PageInterface|null
     */
    public function getNextPage(): ?self;

    /**
     * Gets the total count of resources, not just the number of items in the page.
     * It returns null if the option to process it has not been send in the request.
     *
     * @return int|null
     */
    public function getCount(): int;

    /**
     * Returns the array of resources in the page.
     *
     * @return array
     */
    public function getItems(): array;

    /**
     * Returns true if a next page exists, false either.
     *
     * @return bool
     */
    public function hasNextPage(): bool;

    /**
     * Returns true if a previous page exists, false either.
     *
     * @return bool
     */
    public function hasPreviousPage(): bool;

    /**
     * Gets the link of the next page.
     * Returns null if there is not next page.
     *
     * @return string|null
     */
    public function getNextLink(): ?string;

    /**
     * Gets the link of the last page.
     * Returns null if there is not last page.
     *
     * @return string|null
     */
    public function getLastLink(): string;

    /**
     * Gets the link of the first page.
     *
     * @return string
     */
    public function getFirstLink(): ?string;

    /**
     * Gets the link of the previous page.
     * Returns null if there is not previous page.
     *
     * @return string|null
     */
    public function getPreviousLink(): ?string;
}
