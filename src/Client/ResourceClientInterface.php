<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\Client;

use Eoko\Magento2\Client\Exception\HttpException;

/**
 * Generic client interface to execute common request on resources.
 */
interface ResourceClientInterface
{
    /**
     * Gets a resource.
     *
     * @param string $uri             URI of the resource
     * @param array  $uriParameters   URI parameters of the resource
     * @param array  $queryParameters Query parameters of the request
     *
     * @throws HttpException if the request failed
     *
     * @return array
     */
    public function getResource($uri, array $uriParameters = [], array $queryParameters = []): array;

    /**
     * Gets a list of resources.
     *
     * @param string $uri             URI of the resource
     * @param array  $uriParameters   URI parameters of the resource
     * @param array  $queryParameters Additional query parameters of the request
     *
     * @return array if a query parameter is invalid
     */
    public function getResources($uri, array $uriParameters = [], array $queryParameters = []): array;

    /**
     * Creates a resource.
     *
     * @param string $uri           URI of the resource
     * @param array  $uriParameters URI parameters of the resource
     * @param array  $body          Body of the request
     *
     * @throws HttpException if the request failed
     *
     * @return array Body response
     */
    public function createResource($uri, array $uriParameters = [], array $body = []): array;

    /**
     * Creates a resource if it does not exist yet, otherwise updates partially the resource.
     *
     * @param string $uri           URI of the resource
     * @param array  $uriParameters URI parameters of the resource
     * @param array  $body          Body of the request
     *
     * @throws HttpException if the request failed
     *
     * @return array
     */
    public function updateResource($uri, array $uriParameters = [], array $body = []): array;

    /**
     * Deletes a resource.
     *
     * @param string $uri           URI of the resource to delete
     * @param array  $uriParameters URI parameters of the resource
     *
     * @throws HttpException If the request failed
     *
     * @return int Status code 204 indicating that the resource has been well deleted
     */
    public function deleteResource($uri, array $uriParameters = []);
}
