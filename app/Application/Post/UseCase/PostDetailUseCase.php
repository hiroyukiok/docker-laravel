<?php

namespace App\Application\Post\UseCase;

use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Domain\Post\Entity\Post;

class PostDetailUseCase
{
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * 指定ユーザーの特定の投稿を取得
     *
     * @param int $userId
     * @param int $postId
     * @return Post|null
     */
    public function execute(int $userId, int $postId): ?Post
    {
        // ユーザーIDと投稿IDに基づいて投稿を取得（エンティティとして返される）
        return $this->postRepository->findByIdAndUserId($postId, $userId);
    }
}
