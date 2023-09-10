<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

define('BD_HOST','localhost');
define('BD_USER', 'root');
define('BD_PASSWORD', '');
define('BD_NAME','livraria');

define('DS', DIRECTORY_SEPARATOR);
define('DIR_APP', __DIR__);
define('DIR_PROJETO','api');

define('CHAVE_JWT', '123456');
define('ISS', 'localhost');
define('AUD', 'localhost');

if (!file_exists('autoload.php')) {
    echo 'Erro ao incluir a configuaração';
    exit;
}

include_once 'autoload.php';