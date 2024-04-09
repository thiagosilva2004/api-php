<?php

namespace tests\domain\entities;

use App\domain\entities\Author;
use App\domain\valueObjects\CPF;
use App\domain\valueObjects\Sex;
use App\presentation\languages\LanguageItems;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{

    public function testShouldReturningErrorWhenNameIsEmpty():void
    {
        $author = Author::create(
            0,
            '',
            CPF::create('67600869292'),
            Sex::MAN
        );
        $this->assertInstanceOf(LanguageItems::class, $author);
    }

    public function testShouldReturningErrorWhenNameIsShort():void
    {
        $author = Author::create(
            0,
            'th',
            CPF::create('67600869292'),
            Sex::MAN
        );
        $this->assertInstanceOf(LanguageItems::class, $author);
    }

    public function testShouldReturningAuthorWhenDataIsCorrect():void
    {
        $author = Author::create(
            0,
            'Thiago Silva',
            CPF::create('67600869292'),
            Sex::MAN
        );
        $this->assertInstanceOf(Author::class, $author);
    }
}
