<?php

require_once './../tests/Autoloader.php';
require_once __DIR__.'/../vendor/autoload.php';

$appDir = __DIR__ . '/../src';
$appLoader = new Autoloader('Tuersteher\\Extension', $appDir);
$appLoader->register();
echo '<pre>';
$tuersteher = new \Tuersteher\Tuersteher();
$tuersteher->add('zip', '\\Tuersteher\\Extension\\ZipCode')->country('DE')->username('nilsabegg');
$result = $tuersteher->validate(array('zip' => '76229'));
print_r($result);
$result4 = $tuersteher->validate(array('zip' => '762293'));
print_r($result4);
$tuersteher2 = new \Tuersteher\Tuersteher();
$tuersteher2->add('zip', '\\Tuersteher\\Extension\\ZipCode')->country('DE')->service('ziptastic');
$result2 = $tuersteher2->validate(array('zip' => '76229'));
print_r($result2);
$result3 = $tuersteher2->validate(array('zip' => '762293'));
print_r($result3);
echo '</pre>';
