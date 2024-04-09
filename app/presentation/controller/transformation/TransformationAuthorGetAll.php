<?php

namespace App\presentation\controller\transformation;

use App\presentation\controller\request\AuthorGetAllRequst;
use App\web\request\NetworkRequest;

class TransformationAuthorGetAll
{
    public static function fromNetworkRequest(NetworkRequest $request):AuthorGetAllRequst
    {
        return new AuthorGetAllRequst(
            $request->getBodyDataFieldAsStringNull('name')
        );
    }
}