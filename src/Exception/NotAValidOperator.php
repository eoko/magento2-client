<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\Exception;

use Eoko\Magento2\Client\Search\SearchItem;
use Exception;
use Throwable;

class NotAValidOperator extends Exception
{
    public function __construct(string $operator = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($operator.' is not a valid operator. It must be one of these "'.join(SearchItem::$operators, '", "').'".', $code, $previous);
    }
}
