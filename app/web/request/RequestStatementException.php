<?php

namespace App\web\request;

use App\presentation\languages\LanguageFacade;
use App\presentation\languages\LanguageItems;

class RequestStatementException
{
    public static function execute():void
    {
        $networkResponse = new NetworkResponse();
        $networkResponse->code = 500;
        $networkResponse->data = [];
        $networkResponse->success = false;
        $networkResponse->message = LanguageFacade::getValue(LanguageItems::SERVER_ERROR);

        RequestSendResponse::execute($networkResponse);
    }
}