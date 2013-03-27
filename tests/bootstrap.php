<?php

require_once __DIR__.'/Autoloader.php';
require_once __DIR__.'/../vendor/autoload.php';
$testDir = __DIR__ . '';
$testLoader = new Autoloader('Tuersteher\\Extension\\Test', $testDir);
$testLoader->register();

$appDir = __DIR__ . '/../src';
$appLoader = new Autoloader('Tuersteher\\Extension', $appDir);
$appLoader->register();

