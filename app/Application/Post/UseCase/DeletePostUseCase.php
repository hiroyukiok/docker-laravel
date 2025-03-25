<?php

namespace App\Application\Post\UseCase;

use App\Domain\Post\Repository\PostRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnauthorizedActionException;

class DeletePostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(int $postId): void
    {
        // 現在ログイン中のユーザーを取得
        $currentUser = Auth::id(); // ユーザーIDだけ取得

        // 指定したユーザーIDと投稿IDで検索（エンティティを返す）
        $post = $this->postRepository->findByIdAndUserId($postId, $currentUser);

        if (!$post) {
            throw new UnauthorizedActionException('自分の投稿のみ削除できます。');
        }

        // 削除処理
        $this->postRepository->delete($postId);
    }
}
