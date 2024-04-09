<?php

namespace App\presentation\middlewares;

use App\web\request\NetworkRequest;
use App\web\request\NetworkResponse;

interface MiddlewaresInterface{
    public function execute(NetworkRequest $networkRequest):NetworkResponse;
}