<?php

namespace tests\application\useCases;

use App\application\dtos\AuthorUseCaseAddInput;
use App\application\dtos\AuthorUseCaseDeleteInput;
use App\application\dtos\AuthorUseCaseGetByIdInput;
use App\application\dtos\AuthorUseCaseUpdateInput;
use App\application\useCases\AuthorUseCase;
use App\domain\repositories\AuthorRepository;
use App\domain\entities\Author;
use App\domain\valueObjects\CPF;
use App\domain\valueObjects\Sex;
use PHPUnit\Framework\TestCase;
use tests\fake\CPFFaker;
use tests\fake\NameFaker;
use tests\fake\SexFaker;

class AuthorUseCaseTest extends TestCase
{

    public function test_add_shouldReturningErrorWhenCPFIsInvalid():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
                                    ->disableOriginalConstructor()->getMock();
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->add(
            new AuthorUseCaseAddInput(NameFaker::getNameValid(), SexFaker::getSexValid(),CPFFaker::getCPFInvalid())
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_add_shouldReturningErrorWhenSexIsInvalid():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->add(
            new AuthorUseCaseAddInput(NameFaker::getNameValid(), SexFaker::getSexInvalid(),CPFFaker::getCPFValid())
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_add_shouldReturningErrorWhenCPFAlreadyExist():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorRepository->method('existWithCPF')->willReturn(true);
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->add(
            new AuthorUseCaseAddInput(NameFaker::getNameValid(), SexFaker::getSexValid(),CPFFaker::getCPFValid())
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_add_shouldReturningErrorWhenNameIsInvalid():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorRepository->method('existWithCPF')->willReturn(false);
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->add(
            new AuthorUseCaseAddInput(NameFaker::getNameInvalid(), SexFaker::getSexValid(),CPFFaker::getCPFValid())
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_add_shouldReturningSuccess():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorRepository->method('existWithCPF')->willReturn(false);
        $authorRepository->method('add')->willReturn(2);
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->add(
            new AuthorUseCaseAddInput(NameFaker::getNameValid(), SexFaker::getSexValid(),CPFFaker::getCPFValid())
        );
        $this->assertEmpty($response->errors);
        $this->assertEquals(2,$response->author_id);
    }

    public function test_delete_shouldReturningErrorWhenAuthorIdIsInvalid():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->delete(
            new AuthorUseCaseDeleteInput(null)
        );
        $this->assertNotEmpty($response->errors);
        $response = $authorUseCase->delete(
            new AuthorUseCaseDeleteInput(-1)
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_delete_shouldReturningErrorWhenAuthorNotExist():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorRepository->method('existWithID')->willReturn(false);
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->delete(
            new AuthorUseCaseDeleteInput(5)
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_delete_shouldReturningSuccess():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorRepository->method('existWithID')->willReturn(true);
        $authorRepository->method('delete')->willReturn(true);
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->delete(
            new AuthorUseCaseDeleteInput(5)
        );
        $this->assertEmpty($response->errors);
    }

    public function test_update_shouldReturningErrorWhenAuthorIdIsInvalid():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->update(
            new AuthorUseCaseUpdateInput(-1,NameFaker::getNameValid(), SexFaker::getSexValid())
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_update_shouldReturningErrorWhenNameInvalid():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->update(
            new AuthorUseCaseUpdateInput(5,NameFaker::getNameValid(), SexFaker::getSexInvalid())
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_update_shouldReturningErrorWhenAuthorNotFound():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorRepository->method('getByID')->willReturn(null);
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->update(
            new AuthorUseCaseUpdateInput(5,NameFaker::getNameValid(), SexFaker::getSexInvalid())
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_update_shouldReturningSuccess():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorRepository->method('existWithID')->willReturn(true);
        $authorRepository->method('getByID')->willReturn(
            Author::create(
                5,
                NameFaker::getNameValid(),
                CPF::create(CPFFaker::getCPFValid()),
                Sex::stringToSex(SexFaker::getSexValid())
        ));
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->update(
            new AuthorUseCaseUpdateInput(5,NameFaker::getNameValid(), SexFaker::getSexValid())
        );
        $this->assertEmpty($response->errors);
    }

    public function test_getByID_shouldReturningErrorWhenAuthorIsInvalid():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->getById(
            new AuthorUseCaseGetByIdInput(null)
        );
        $this->assertNotEmpty($response->errors);
        $response = $authorUseCase->getById(
            new AuthorUseCaseGetByIdInput(-1)
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_getByID_shouldReturningErrorWhenAuthorNotFound():void
    {
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorRepository->expects(self::once())->method('getByID')->willReturn(null);
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->getById(
            new AuthorUseCaseGetByIdInput(5)
        );
        $this->assertNotEmpty($response->errors);
    }

    public function test_getByID_shouldSuccessReturningESuccess():void
    {
        $author = Author::create(
            5,
            NameFaker::getNameValid(),
            CPF::create(CPFFaker::getCPFValid()),
            Sex::stringToSex(SexFaker::getSexValid())
        );
        $authorRepository = $this->getMockBuilder(AuthorRepository::class)
            ->disableOriginalConstructor()->getMock();
        $authorRepository->expects(self::once())->method('getByID')->willReturn($author);
        $authorUseCase = new AuthorUseCase($authorRepository);
        $response = $authorUseCase->getById(
            new AuthorUseCaseGetByIdInput(5)
        );
        $this->assertEmpty($response->errors);
        $this->assertEquals($author,$response->authors);
    }
}
