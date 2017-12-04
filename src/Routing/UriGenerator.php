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

use Eoko\Magento2\Client\Pagination\PaginationParameter;

/**
 * Generate a complete uri from a base path, uri parameters, and query parameters.
 */
class UriGenerator implements UriGeneratorInterface
{
    /** @var string */
    protected $baseUri;

    /**
     * @param string $baseUri Base URI of the API
     */
    public function __construct($baseUri)
    {
        $this->baseUri = rtrim($baseUri, '/');
    }

    /**
     * {@inheritdoc}
     */
    public function generate($path, array $uriParameters = [], array $queryParameters = [])
    {
        $uriParameters = $this->encodeUriParameters($uriParameters);

        $uri = $this->baseUri.'/'.vsprintf(ltrim($path, '/'), $uriParameters);

        $queryParameters = $this->booleanQueryParametersAsString($queryParameters);

        if (isset($queryParameters[PaginationParameter::SEARCH])) {
            $queryParameters[PaginationParameter::SEARCH] = json_encode($queryParameters[PaginationParameter::SEARCH]);
        }

        if (!empty($queryParameters)) {
            $uri .= '?'.http_build_query($queryParameters, null, '&', PHP_QUERY_RFC3986);
        }

        return $uri;
    }

    /**
     * Transforms boolean query parameters as string 'true' or 'false' instead of 0 or 1.
     *
     * @param array $queryParameters
     *
     * @return array
     */
    protected function booleanQueryParametersAsString(array $queryParameters)
    {
        return array_map(function ($queryParameters) {
            if (!is_bool($queryParameters)) {
                return $queryParameters;
            }

            return true === $queryParameters ? 'true' : 'false';
        }, $queryParameters);
    }

    /**
     * Slash character should not be url encoded because it is not allowed
     * by the webservers for security reasons.
     *
     * This character can be used by product identifier and media code.
     *
     * @param array $uriParameters
     *
     * @return array
     */
    protected function encodeUriParameters(array $uriParameters)
    {
        return array_map(function ($uriParameter) {
            $uriParameter = rawurlencode($uriParameter);

            return preg_replace('~\%2F~', '/', $uriParameter);
        }, $uriParameters);
    }
}
