<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\tests\Common\Api\Integration;

use Eoko\Magento2\Client\tests\AbstractApiTestCase;

class AdminTokenIntegration extends AbstractApiTestCase
{
    public function testCreateToken()
    {
        $user = $this->getConfiguration()['magento2']['admin_user'];
        $password = $this->getConfiguration()['magento2']['admin_password'];
        $api = $this->createUnauthenticatedClient()->getAdminTokenApi();
        $response = $api->getAdminToken($user, $password);

        $this->assertTrue(is_string($response));
    }
}
