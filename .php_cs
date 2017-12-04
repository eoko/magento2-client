<?php
use PhpCsFixer\Config;
$header = <<<EOF
This file is part of eoko\magento2.

PHP Version 7.1

@author    Romain DARY <romain.dary@eoko.fr>
@copyright 2011-2018 Eoko. All rights reserved.
EOF;
$config = new Config();
$config->getFinder()
    ->files()
    ->in(__DIR__)
    ->exclude('vendor')
    ->exclude('docs')
    ->exclude('examples')
    ->name('*.php');
$config
    ->setRules(array(
        '@PSR2' => true,
        '@Symfony' => true,
        'header_comment' => array('header' => $header),
    ));
return $config;