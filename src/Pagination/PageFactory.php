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
 * Factory to create a page object representing a list of resources.
 */
class PageFactory implements PageFactoryInterface
{
    /** @var HttpClientInterface */
    protected $httpClient;

    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * {@inheritdoc}
     */
    public function createPage(array $data): PageInterface
    {
        /** @todo remove dirty patch */
        $uri = $data['_links']['self']['href'];

        return new Page(new self($this->httpClient), $this->httpClient, $uri, $data);
    }
}
