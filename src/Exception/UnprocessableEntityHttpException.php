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
 * Exception thrown when it is the request is unprocessable (422).
 */
class UnprocessableEntityHttpException extends ClientErrorHttpException
{
    /**
     * Returns the errors of the response if there are any.
     *
     * @return array
     */
    public function getResponseErrors()
    {
        $responseBody = $this->response->getBody();

        $responseBody->rewind();
        $decodedBody = json_decode($responseBody->getContents(), true);
        $responseBody->rewind();

        return isset($decodedBody['errors']) ? $decodedBody['errors'] : [];
    }
}
