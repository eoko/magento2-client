<?php

/*
 * This file is part of eoko\magento2.
 *
 * PHP Version 7.1
 *
 * @author    Romain DARY <romain.dary@eoko.fr>
 * @copyright 2011-2018 Eoko. All rights reserved.
 */

namespace Eoko\Magento2\Client\tests;

use Eoko\Magento2\Client\MagentoClientBuilder;
use Eoko\Magento2\Client\MagentoClientInterface;
use Eoko\Magento2\Client\Security\AdminAuthentication;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\StreamFactory;
use Symfony\Component\Yaml\Yaml;

abstract class AbstractApiTestCase extends \PHPUnit_Framework_TestCase
{
    /** @var array */
    private $configuration;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->configuration = $this->parseConfigurationFile();
    }

    /**
     * @return StreamFactory
     */
    protected function getStreamFactory()
    {
        return StreamFactoryDiscovery::find();
    }

    /**
     * @return MagentoClientInterface
     */
    protected function createClient()
    {
        $config = $this->getConfiguration();

        $clientBuilder = new MagentoClientBuilder($config['magento2']['base_uri']);

        $user = $this->getConfiguration()['magento2']['admin_user'];
        $password = $this->getConfiguration()['magento2']['admin_password'];
        $api = $this->createUnauthenticatedClient()->getAdminTokenApi();
        $token = $api->getAdminToken($user, $password);

        $authentication = AdminAuthentication::fromAdminToken($token);

        return $clientBuilder->buildAuthenticatedClient($authentication);
    }

    /**
     * @return MagentoClientInterface
     */
    protected function createUnauthenticatedClient()
    {
        $config = $this->getConfiguration();

        $clientBuilder = new MagentoClientBuilder($config['magento2']['base_uri']);

        return $clientBuilder->buildAuthenticatedClient();
    }

    /**
     * @return array
     */
    protected function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Assert that all the expected data of a content of a resource are the same
     * in an actual one.
     * An associative array can contain more elements than expected, but an
     * numeric key array must be strictly identical.
     *
     * @param array $expectedContent
     * @param array $actualContent
     */
    protected function assertSameContent(array $expectedContent, array $actualContent)
    {
        $expectedContent = $this->sortResourceContent($expectedContent);
        $actualContent = $this->sortResourceContent($actualContent);

        $expectedContent = $this->mergeResourceContents($actualContent, $expectedContent);

        $this->assertSame($expectedContent, $actualContent);
    }

    /**
     * @return string
     */
    protected function getConfigurationFile()
    {
        return realpath(dirname(__FILE__)).'/etc/parameters.yml';
    }

    /**
     * @throws \RuntimeException
     *
     * @return array
     */
    private function parseConfigurationFile()
    {
        $configFile = $this->getConfigurationFile();
        if (!is_file($configFile)) {
            throw new \RuntimeException('The configuration file parameters.yml is missing');
        }

        $config = Yaml::parse(file_get_contents($configFile));

        return $config;
    }

    /**
     * Recursively merge an expected content in a actual one to be able to compare them.
     * Numeric key arrays are kept identical.
     *
     * @param array $actualContent
     * @param array $expectedContent
     *
     * @return array
     */
    private function mergeResourceContents(array $actualContent, array $expectedContent)
    {
        foreach ($expectedContent as $key => $value) {
            if (is_array($value) && isset($actualContent[$key]) && is_array($actualContent[$key])) {
                $expectedContent[$key] = $this->mergeResourceContents($actualContent[$key], $expectedContent[$key]);
            }
        }

        if ($this->isAssociativeArray($expectedContent)) {
            $mergedContent = array_merge($actualContent, $expectedContent);
        } else {
            $mergedContent = $expectedContent;
        }

        return $mergedContent;
    }

    /**
     * @param array $array
     *
     * @return bool True if the array is associative (i.e. at least one key is a string)
     */
    private function isAssociativeArray(array $array)
    {
        foreach (array_keys($array) as $key) {
            if (is_string($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Sort a resource content to be able to compare it with another one.
     * The order of elements in an associative array is important in PHPUnit but not for us.
     * So we force the order of the associative arrays to be identical to be able to use them in a PHPUnit assertion.
     * This sort has no consequences for sequential arrays with numeric keys.
     *
     * @param array $resourceContent
     *
     * @return array Sorted resource content
     */
    private function sortResourceContent(array $resourceContent)
    {
        ksort($resourceContent);

        foreach ($resourceContent as $key => $value) {
            if (is_array($value)) {
                $resourceContent[$key] = $this->sortResourceContent($value);
            }
        }

        return $resourceContent;
    }
}
