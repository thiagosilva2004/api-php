<?php

namespace App\presentation\controller\transformation;

use App\presentation\controller\request\AuthorPutRequest;
use App\web\request\NetworkRequest;

class TransformationAuthorPut
{
    public static function fromNetworkRequest(NetworkRequest $request): AuthorPutRequest
    {
        return new AuthorPutRequest(
            $request->getBodyDataFieldAsInt('author_id'),
            $request->getBodyDataFieldAsString('name'),
            $request->getBodyDataFieldAsString('cpf'),
            $request->getBodyDataFieldAsString('sex'),
        );
    }
}