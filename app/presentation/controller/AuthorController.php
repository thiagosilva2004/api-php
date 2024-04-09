<?php

namespace App\presentation\controller;
use App\application\dtos\AuthorUseCaseAddInput;
use App\application\dtos\AuthorUseCaseDeleteInput;
use App\application\dtos\AuthorUseCaseGetAllInput;
use App\application\dtos\AuthorUseCaseGetByIdInput;
use App\application\dtos\AuthorUseCaseUpdateInput;
use App\application\useCases\AuthorUseCase;
use App\presentation\controller\transformation\TransformationAuthorAdd;
use App\presentation\controller\transformation\TransformationAuthorDelete;
use App\presentation\controller\transformation\TransformationAuthorGetAll;
use App\presentation\controller\transformation\TransformationAuthorGetById;
use App\presentation\controller\transformation\TransformationAuthorPut;
use App\presentation\languages\LanguageItems;
use App\web\request\NetworkRequest;
use App\web\request\NetworkResponse;

class AuthorController
{
    public function __construct(
        private readonly AuthorUseCase $authorUseCase
    ){}

    public function add(NetworkRequest $networkRequest): NetworkResponse
    {
       $request = TransformationAuthorAdd::fromNetworkRequest($networkRequest);
       $authorAddInput = new AuthorUseCaseAddInput(
           name: $request->name,
           sex: $request->sex,
           cpf: $request->cpf
       );
       $authorAddOutput = $this->authorUseCase->add($authorAddInput);

       if(count($authorAddOutput->errors) > 0){
           return new NetworkResponse(
               code: 400, message: $authorAddOutput->errors[0], success: false
           );
       }

        return new NetworkResponse(
            code: 200, data: ["author_id" => $authorAddOutput->author_id], success: true
        );
    }

    public function delete(NetworkRequest $networkRequest):NetworkResponse
    {
        $request = TransformationAuthorDelete::fromNetworkRequest($networkRequest);
        $authorDeleteOutput = $this->authorUseCase->delete(new AuthorUseCaseDeleteInput($request->author_id));
        if(count($authorDeleteOutput->errors) > 0){
            return new NetworkResponse(code: 400, message: $authorDeleteOutput->errors[0], success: false);
        }
        return new NetworkResponse(code: 200, data: [], success: true);
    }

    public function update(NetworkRequest $networkRequest):NetworkResponse
    {
        $request = TransformationAuthorPut::fromNetworkRequest($networkRequest);
        $authorUpdateOutput = $this->authorUseCase->update(
            new AuthorUseCaseUpdateInput($request->id,$request->name,$request->sex)
        );
        if(count($authorUpdateOutput->errors) > 0){
            return new NetworkResponse(code: 400, message: $authorUpdateOutput->errors[0], success: false);
        }
        return new NetworkResponse(code: 200, data: [], success: true);
    }

    public function getAll(NetworkRequest $networkRequest):NetworkResponse{
        $request = TransformationAuthorGetAll::fromNetworkRequest($networkRequest);
        $authorGetAllOutput = $this->authorUseCase->getAll(
            new AuthorUseCaseGetAllInput($request->name)
        );
        if(count($authorGetAllOutput->errors) > 0){
            return new NetworkResponse(code: 400, message: $authorGetAllOutput->errors[0], success: false);
        }
        return new NetworkResponse(code: 200, data: ["authors" => $authorGetAllOutput->authors], success: true);
    }

    public function getById(NetworkRequest $networkRequest):NetworkResponse{
        $request = TransformationAuthorGetById::fromNetworkRequest($networkRequest);
        $authorGetByIdOutput = $this->authorUseCase->getById(new AuthorUseCaseGetByIdInput($request->id));
        if(count($authorGetByIdOutput->errors) > 0){
            if($authorGetByIdOutput->errors[0] === LanguageItems::AUTHOR_NOT_FOUND){
                return new NetworkResponse(code: 404, message: $authorGetByIdOutput->errors[0], success: false);
            }
            return new NetworkResponse(code: 400, message: $authorGetByIdOutput->errors[0], success: false);
        }
        return new NetworkResponse(code: 200, data: ["author" => $authorGetByIdOutput->authors], success: true);
    }
}