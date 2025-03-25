<?php

namespace App\Application\Post\DTO;

class PostDTO
{
    public string $title;
    public string $content;

    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }
    

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
