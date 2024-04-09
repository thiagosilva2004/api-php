<?php

namespace App\presentation\controller\transformation;

use App\presentation\controller\request\AuthorAddRequest;
use App\web\request\NetworkRequest;

class TransformationAuthorAdd
{
    public static function fromNetworkRequest(NetworkRequest $request):AuthorAddRequest
    {
        return new AuthorAddRequest(
            $request->getBodyDataFieldAsString('name'),
            $request->getBodyDataFieldAsString('cpf'),
            $request->getBodyDataFieldAsString('sex'),
        );
    }
}