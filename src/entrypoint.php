<?php
namespace DannyNimmo\SortSequelProFavourites;

if (php_sapi_name() !== 'cli') {
    die('Script must run via CLI');
}

require_once 'classes/App.php';
require_once 'classes/Cli.php';
require_once 'classes/File.php';

$app = new App();
$app->start();
