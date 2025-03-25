<?php

namespace App\Domain\Post\Entity;

use App\Domain\User\Entity\User;

class Post
{
    private ?int $id; // idをnullableに変更
    private int $userId;
    private string $title;
    private string $content;
    private ?string $userName; // ユーザーの名前を格納するプロパティを追加

    public function __construct(?int $id, int $userId, string $title, string $content, ?string $userName = null)
    {
        $this->id = $id; // 新規作成時はnullを許容
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->userName = $userName; // ユーザー名を格納
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        if ($this->id === null) {
            $this->id = $id;
        }
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    // ユーザー名を取得するメソッド
    public function getName(): ?string
    {
        return $this->userName;
    }
}
