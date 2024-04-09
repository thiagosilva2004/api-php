<?php

namespace App\domain\entities;

use DateTime;

class Post
{
    public function __construct(
        private int $id,
        private int $author_id,
        private string $title,
        private string $body,
        private DateTime $create_at
    ){}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAuthorId(): int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $author_id): void
    {
        $this->author_id = $author_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getCreateAt(): DateTime
    {
        return $this->create_at;
    }

    public function setCreateAt(DateTime $create_at): void
    {
        $this->create_at = $create_at;
    }
}