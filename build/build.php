<?php
namespace DannyNimmo\SortSequelProFavourites;

$rootDir = dirname(__DIR__);
$srcDir  = $rootDir . '/src';

$name = 'sort-sequel-pro-favourites.phar';
$phar = new \Phar(
    $rootDir . '/' . $name,
    \FilesystemIterator::NEW_CURRENT_AND_KEY,
    $name
);

$files = [
    'entrypoint.php',
    'classes/App.php',
    'classes/Cli.php',
    'classes/File.php',
];
foreach ($files as $file) {
    $phar[$file] = file_get_contents($srcDir . '/' . $file);
}

$hashbang = '#!/usr/bin/env php';
$phar->setStub(
    $hashbang . "\n" .
    $phar->createDefaultStub('entrypoint.php')
);
