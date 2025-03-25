<?php

namespace App\Application\Post\UseCase;

use App\Domain\Post\Repository\PostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PostListUseCase
{
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * 指定ユーザーの投稿一覧を取得（ページング対応）
     *
     * @param int $userId
     * @param int $perPage ページあたりの投稿数（デフォルトは10）
     * @return LengthAwarePaginator
     */
    public function execute(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        // ユーザーIDに基づいて投稿を取得（ページング対応）
        return $this->postRepository->findByUserId($userId, $perPage);
    }
}
