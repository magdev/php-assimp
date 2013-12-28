<?php

define('ASSIMP_TEST_FILES', __DIR__.'/files');

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('Assimp\Tests', __DIR__);
