<?php

namespace App\presentation\controller\transformation;

use App\web\request\NetworkRequest;

class TransformationAuthorGetById
{
    public static function fromNetworkRequest(NetworkRequest $request):AuthorGetByIdRequest
    {
        return new AuthorGetByIdRequest(
            $request->getRouterDataFieldAsInt('author_id'),
        );
    }
}