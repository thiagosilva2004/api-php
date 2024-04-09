<?php

use App\di\ContainerBuilder;
use App\infrastructure\log\Log;
use App\infrastructure\log\LogHandleException;
use App\web\request\RequestStatementExecute;

header('Acess-Control-Allow-Origin *');
header('Content-Type: application/json; charset=UTF-8');

require_once 'vendor/autoload.php';
require_once 'bootstrap.php';

$requestStatement = ContainerBuilder::get(RequestStatementExecute::class);
$requestStatement->start();