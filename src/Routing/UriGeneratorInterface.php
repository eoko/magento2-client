<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\Routing;

use Psr\Http\Message\UriInterface;

/**
 * Interface to generate a complete uri from a base path, uri parameters, and query parameters.
 */
interface UriGeneratorInterface
{
    /**
     * Generate an uri from a path, by adding host and port.
     *
     * @param string $path            Path of the endpoint
     * @param array  $uriParameters   List of the parameters to generate the endpoint
     * @param array  $queryParameters List of the query parameters added to the endpoint
     *
     * @return UriInterface
     */
    public function generate($path, array $uriParameters = [], array $queryParameters = []);
}
