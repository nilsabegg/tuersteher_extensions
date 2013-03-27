<?php

require_once './../tests/Autoloader.php';
require_once __DIR__.'/../vendor/autoload.php';

$appDir = __DIR__ . '/../src';
$appLoader = new Autoloader('Tuersteher\\Extension', $appDir);
$appLoader->register();
echo '<pre>';
$tuersteher = new \Tuersteher\Tuersteher();
$tuersteher->add('zip', '\\Tuersteher\\Extension\\ZipCode')->country('DE');
$result = $tuersteher->validate(array('zip' => '76229'));

print_r($result);
echo '</pre>';
