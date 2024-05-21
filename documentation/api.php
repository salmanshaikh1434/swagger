<?php

spl_autoload_register('autoloader');
function autoloader(string $name)
{
    if (file_exists('../objects/' . $name . '.php')) {
        require_once '../objects/' . $name . '.php';
    }
}
require ($_SERVER['DOCUMENT_ROOT'] . "/apidb/vendor/autoload.php");

$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'] . '/apidb/objects']);
header('Content-Type: application/json');

echo $openapi->toJSON();