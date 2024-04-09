<?php

namespace tests\presentation\controller;

use App\application\dtos\AuthorUseCaseAddOutput;
use App\application\dtos\AuthorUseCaseDeleteOutput;
use App\application\dtos\AuthorUseCaseGetByIdOutput;
use App\application\dtos\AuthorUseCaseUpdateOutput;
use App\application\useCases\AuthorUseCase;
use App\domain\entities\Author;
use App\presentation\controller\AuthorController;
use App\presentation\languages\LanguageItems;
use App\web\request\NetworkRequest;
use PHPUnit\Framework\TestCase;

class AuthorControllerTest extends TestCase
{

    public function test_add_ShouldReturningErrorWhenUseCaseHasErrors():void
    {
        $networkRequest = $this->getMockBuilder(NetworkRequest::class)->disableOriginalConstructor()->getMock();
        $authorUseCase = $this->getMockBuilder(AuthorUseCase::class)->disableOriginalConstructor()->getMock();
        $authorUseCase->method('add')->willReturn(
            new AuthorUseCaseAddOutput(array(LanguageItems::SERVER_ERROR),0)
        );
        $authorController = new AuthorController($authorUseCase);
        $response = $authorController->add($networkRequest);
        $this->assertFalse($response->success);
        $this->assertEquals(400,$response->code);
    }

    public function test_add_ShouldReturningSuccessWhenUseCaseNotHasErrors():void
    {
        $networkRequest = $this->getMockBuilder(NetworkRequest::class)->disableOriginalConstructor()->getMock();
        $authorUseCase = $this->getMockBuilder(AuthorUseCase::class)->disableOriginalConstructor()->getMock();
        $authorUseCase->method('add')->willReturn(
            new AuthorUseCaseAddOutput(array(),0)
        );
        $authorController = new AuthorController($authorUseCase);

        $response = $authorController->add($networkRequest);
        $this->assertTrue($response->success);
        $this->assertEquals(200,$response->code);
    }

    public function test_getById_ShouldReturning404WhenIdNotFound():void
    {
        $networkRequest = $this->getMockBuilder(NetworkRequest::class)->disableOriginalConstructor()->getMock();
        $authorUseCase = $this->getMockBuilder(AuthorUseCase::class)->disableOriginalConstructor()->getMock();
        $authorUseCase->method('getById')->willReturn(
            new AuthorUseCaseGetByIdOutput(array(LanguageItems::AUTHOR_NOT_FOUND),null)
        );
        $authorController = new AuthorController($authorUseCase);
        $response = $authorController->getById($networkRequest);
        $this->assertFalse($response->success);
        $this->assertEquals(404,$response->code);
    }

    public function test_getById_ShouldReturningUserWhenExist():void
    {
        $author = $this->getMockBuilder(Author::class)->disableOriginalConstructor()->getMock();
        $networkRequest = $this->getMockBuilder(NetworkRequest::class)->disableOriginalConstructor()->getMock();
        $authorUseCase = $this->getMockBuilder(AuthorUseCase::class)->disableOriginalConstructor()->getMock();
        $authorUseCase->method('getById')->willReturn(
            new AuthorUseCaseGetByIdOutput(array(),$author)
        );
        $authorController = new AuthorController($authorUseCase);
        $response = $authorController->getById($networkRequest);
        $this->assertTrue($response->success);
        $this->assertEquals(200,$response->code);
        $this->assertEquals($author, $response->data["author"]);
    }

    public function test_update_ShouldReturningErrorWhenUseCaseHasErrors():void
    {
        $networkRequest = $this->getMockBuilder(NetworkRequest::class)->disableOriginalConstructor()->getMock();
        $authorUseCase = $this->getMockBuilder(AuthorUseCase::class)->disableOriginalConstructor()->getMock();
        $authorUseCase->method('update')->willReturn(
            new AuthorUseCaseUpdateOutput(array(LanguageItems::SERVER_ERROR))
        );
        $authorController = new AuthorController($authorUseCase);
        $response = $authorController->update($networkRequest);

        $this->assertFalse($response->success);
        $this->assertEquals(400,$response->code);
    }

    public function test_update_ShouldReturningSuccessWhenUseCaseNotHasErrors():void
    {
        $networkRequest = $this->getMockBuilder(NetworkRequest::class)->disableOriginalConstructor()->getMock();
        $authorUseCase = $this->getMockBuilder(AuthorUseCase::class)->disableOriginalConstructor()->getMock();
        $authorUseCase->method('update')->willReturn(
            new AuthorUseCaseUpdateOutput(array())
        );
        $authorController = new AuthorController($authorUseCase);

        $response = $authorController->update($networkRequest);
        $this->assertTrue($response->success);
        $this->assertEquals(200,$response->code);
    }

    public function test_delete_ShouldReturningErrorWhenUseCaseHasErrors():void
    {
        $networkRequest = $this->getMockBuilder(NetworkRequest::class)->disableOriginalConstructor()->getMock();
        $authorUseCase = $this->getMockBuilder(AuthorUseCase::class)->disableOriginalConstructor()->getMock();
        $authorUseCase->method('delete')->willReturn(
            new AuthorUseCaseDeleteOutput(array(LanguageItems::SERVER_ERROR))
        );
        $authorController = new AuthorController($authorUseCase);
        $response = $authorController->delete($networkRequest);

        $this->assertFalse($response->success);
        $this->assertEquals(400,$response->code);
    }

    public function test_delete_ShouldReturningSuccessWhenUseCaseNotHasErrors():void
    {
        $networkRequest = $this->getMockBuilder(NetworkRequest::class)->disableOriginalConstructor()->getMock();
        $authorUseCase = $this->getMockBuilder(AuthorUseCase::class)->disableOriginalConstructor()->getMock();
        $authorUseCase->method('delete')->willReturn(
            new AuthorUseCaseDeleteOutput(array())
        );
        $authorController = new AuthorController($authorUseCase);

        $response = $authorController->delete($networkRequest);
        $this->assertTrue($response->success);
        $this->assertEquals(200,$response->code);
    }
}
