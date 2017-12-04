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

use Eoko\Magento2\Client\Client\HttpClientInterface;

/**
 * Page represents a list of paginated resources.
 */
class Page implements PageInterface
{
    /** @var PageFactoryInterface */
    protected $pageFactory;

    /** @var HttpClientInterface */
    protected $httpClient;

    /** @var string */
    protected $firstLink;

    /** @var string */
    protected $lastLink;

    /** @var string */
    protected $previousLink;

    /** @var string */
    protected $nextLink;

    /** @var int */
    protected $count;

    /** @var array */
    protected $items;

    /**
     * @param PageFactoryInterface $pageFactory
     * @param HttpClientInterface  $httpClient
     * @param string               $uri
     * @param array                $data
     *
     * @internal param string $firstLink
     * @internal param null|string $previousLink
     * @internal param null|string $nextLink
     * @internal param int|null $count
     * @internal param array $items
     */
    public function __construct(PageFactoryInterface $pageFactory, HttpClientInterface $httpClient, string $uri, $data)
    {
        $this->pageFactory = $pageFactory;
        $this->httpClient = $httpClient;

        $parseUrl = parse_url($uri);
        parse_str($parseUrl['query'], $currentQuery);

        $currentQuery['searchCriteria'] = isset($currentQuery['searchCriteria']) ? $currentQuery['searchCriteria'] : [];

        $data['search_criteria'] = isset($data['search_criteria']) ? $data['search_criteria'] : [];
        $currentPage = isset($data['search_criteria']['current_page']) ? $data['search_criteria']['current_page'] : 1;
        $currentSize = isset($data['search_criteria']['page_size']) ? $data['search_criteria']['page_size'] : 10;
        $count = isset($data['total_count']) ? $data['total_count'] : 0;
        $items = $data['items'];

        $firstQuery = $currentQuery;
        $firstQuery['searchCriteria']['currentPage'] = 1;
        $parseUrl['query'] = $firstQuery;
        $this->firstLink = $this->unparseUrl($parseUrl);

        $prevQuery = $currentQuery;
        $prev = $currentPage - 1;
        $prevQuery['searchCriteria']['currentPage'] = $prev > 0 ? $prev : null;
        $parseUrl['query'] = $prevQuery;
        $this->previousLink = $prev ? $this->unparseUrl($parseUrl) : null;

        $nextQuery = $currentQuery;
        $next = ($currentPage + 1) * $currentSize <= $count ? $currentPage + 1 : null;
        $nextQuery['searchCriteria']['currentPage'] = $next;
        $parseUrl['query'] = $nextQuery;
        $this->nextLink = $next ? $this->unparseUrl($parseUrl) : null;

        $lastQuery = $currentQuery;
        $last = ceil($count / $currentSize);
        $lastQuery['searchCriteria']['currentPage'] = $last;
        $parseUrl['query'] = $lastQuery;
        $this->lastLink = $last ? $this->unparseUrl($parseUrl) : null;

        $this->count = $count;
        $this->items = $items;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastPage(): PageInterface
    {
        return $this->getPage($this->lastLink);
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstPage(): PageInterface
    {
        return $this->getPage($this->firstLink);
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousPage(): ?PageInterface
    {
        return $this->hasPreviousPage() ? $this->getPage($this->previousLink) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextPage(): ?PageInterface
    {
        return $this->hasNextPage() ? $this->getPage($this->nextLink) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function hasNextPage(): bool
    {
        return null !== $this->nextLink;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPreviousPage(): bool
    {
        return null !== $this->previousLink;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextLink(): ?string
    {
        return $this->nextLink;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreviousLink(): ?string
    {
        return $this->previousLink;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastLink(): string
    {
        return $this->lastLink;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstLink(): string
    {
        return $this->firstLink;
    }

    /**
     * Returns the page given a complete uri.
     *
     * @param string $uri
     *
     * @return PageInterface
     */
    protected function getPage($uri): PageInterface
    {
        $response = $this->httpClient->sendRequest('GET', $uri, ['Accept' => '*/*']);
        $data = json_decode($response->getBody()->getContents(), true);

        /* @todo remove dirty patch */
        $data['_links']['self']['href'] = $uri;

        return $this->pageFactory->createPage($data);
    }

    /**
     * @param $parsedUrl
     *
     * @return string
     *
     * @todo fix dirty
     */
    private function unparseUrl($parsedUrl)
    {
        $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'].'://' : '';
        $host = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $port = isset($parsedUrl['port']) ? ':'.$parsedUrl['port'] : '';
        $user = isset($parsedUrl['user']) ? $parsedUrl['user'] : '';
        $pass = isset($parsedUrl['pass']) ? ':'.$parsedUrl['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $query = isset($parsedUrl['query']) ? '?'.http_build_query($parsedUrl['query']) : '';
        $fragment = isset($parsedUrl['fragment']) ? '#'.$parsedUrl['fragment'] : '';

        return "$scheme$user$pass$host$port$path$query$fragment";
    }
}
