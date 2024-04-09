<?php

namespace App\presentation\controller\transformation;

use App\presentation\controller\request\AuthorDeleteRequest;
use App\web\request\NetworkRequest;

class TransformationAuthorDelete
{
    public static function fromNetworkRequest(NetworkRequest $request):AuthorDeleteRequest
    {
        return new AuthorDeleteRequest(
            $request->getBodyDataFieldAsInt('author_id')
        );
    }
}