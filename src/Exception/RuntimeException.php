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

/**
 * Exception thrown if an error which can only be found on runtime occurs in the API client.
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
}
