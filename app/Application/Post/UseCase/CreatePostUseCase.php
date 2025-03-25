<?php

namespace App\Application\Post\UseCase;

use App\Domain\Post\Entity\Post;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Exceptions\UnauthorizedActionException;
use Illuminate\Support\Facades\Auth;
use App\Application\Post\DTO\PostDTO;

class CreatePostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * 投稿を作成する
     *
     * @param PostDTO $postDTO タイトルとコンテンツのデータ
     * @return Post 作成した投稿
     */
    public function execute(PostDTO $postDTO): Post
    {
        $currentUser = Auth::user();

        // idをnullにしてPostを作成
        $post = new Post(null, $currentUser->id, $postDTO->title, $postDTO->content);

        // リポジトリを通じて保存（保存後のPostを取得）
        $savedPost = $this->postRepository->save($post);

        // 保存後のIDをセット
        $post->setId($savedPost->getId());

        return $post;
    }

}
