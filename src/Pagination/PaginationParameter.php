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
 * This class contains the list of parameters to use for the pagination of the API.
 */
final class PaginationParameter
{
    const SEARCH = 'search';
    const LIMIT = 'limit';
    const WITH_COUNT = 'with_count';
}
