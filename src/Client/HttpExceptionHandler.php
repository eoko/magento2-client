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

use Eoko\Magento2\Client\Exception\BadRequestHttpException;
use Eoko\Magento2\Client\Exception\ClientErrorHttpException;
use Eoko\Magento2\Client\Exception\NotFoundHttpException;
use Eoko\Magento2\Client\Exception\ServerErrorHttpException;
use Eoko\Magento2\Client\Exception\UnauthorizedHttpException;
use Eoko\Magento2\Client\Exception\UnprocessableEntityHttpException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * It aims to throw exception thanks to the the response's HTTP status code if the request has failed.
 */
class HttpExceptionHandler
{
    /**
     * Transforms response to an exception if possible.
     *
     * @param RequestInterface  $request  Request of the call
     * @param ResponseInterface $response Response of the call
     *
     * @throws BadRequestHttpException          If response status code is a 400
     * @throws UnauthorizedHttpException        If response status code is a 401
     * @throws NotFoundHttpException            If response status code is a 404
     * @throws UnprocessableEntityHttpException If response status code is a 422
     * @throws ClientErrorHttpException         If response status code is a 4xx
     * @throws ServerErrorHttpException         If response status code is a 5xx
     *
     * @return ResponseInterface
     */
    public function transformResponseToException(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if (400 === $response->getStatusCode()) {
            throw new BadRequestHttpException($this->getResponseMessage($response), $request, $response);
        }

        if (401 === $response->getStatusCode()) {
            throw new UnauthorizedHttpException($this->getResponseMessage($response), $request, $response);
        }

        if (404 === $response->getStatusCode()) {
            throw new NotFoundHttpException($this->getResponseMessage($response), $request, $response);
        }

        if (422 === $response->getStatusCode()) {
            throw new UnprocessableEntityHttpException($this->getResponseMessage($response), $request, $response);
        }

        if ($response->getStatusCode() >= 400 && $response->getStatusCode() < 500) {
            throw new ClientErrorHttpException($this->getResponseMessage($response), $request, $response);
        }

        if ($response->getStatusCode() >= 500 && $response->getStatusCode() < 600) {
            throw new ServerErrorHttpException($this->getResponseMessage($response), $request, $response);
        }

        return $response;
    }

    /**
     * Returns the response message, or the reason phrase if there is none.
     *
     * @param ResponseInterface $response
     *
     * @return string
     */
    protected function getResponseMessage(ResponseInterface $response): string
    {
        $responseBody = $response->getBody();

        $responseBody->rewind();
        $decodedBody = json_decode($responseBody->getContents(), true);
        $responseBody->rewind();

        return isset($decodedBody['message']) ? $decodedBody['message'] : $response->getReasonPhrase();
    }
}
