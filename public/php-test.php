<?php

chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

Raven_Autoloader::register();
$client = new Raven_Client('http://374391199999ad5ac2719b8fd7e04ff0:9d8d911d1db9cce7000dfb3eb3b4d763@localhost/prison/public/prison/1');

// record a simple message
$client->captureMessage('hello world!');

// capture an exception
try {
    throw new Exception('Uh oh!');
}
catch (Exception $e) {
    $client->captureException($e);
}

echo "Reported - ";

var_dump($client->getLastError());