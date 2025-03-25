<?php

namespace App\Domain\Post\Repository;

use App\Domain\Post\Entity\Post;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    /**
     * ユーザーIDと投稿IDに基づいて単一投稿を取得（Eloquent）
     *
     * @param int $id
     * @param int $userId
     * @return \App\Models\Post|null
     */
    public function getEloquentByIdAndUserId(int $id, int $userId): ?\App\Models\Post;

    /**
     * ユーザーIDに基づいて複数の投稿を取得（ページング対応）
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findByUserId(int $userId, int $perPage = 10): LengthAwarePaginator;
    
    /**
     * ユーザーIDに基づいて複数の投稿を取得（ページネーション）
     *
     * @param int $userId
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getEloquentPostByUserId(int $userId): LengthAwarePaginator;

    /**
     * 投稿を削除
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * 投稿を保存（新規作成または更新）
     *
     * @param Post $post
     * @return void
     */
    public function save(Post $post): Post;

    /**
     * ユーザーIDと投稿IDに基づいて単一の投稿を取得（エンティティ）
     *
     * @param int $id
     * @param int $userId
     * @return Post|null
     */
    public function findByIdAndUserId(int $userId ,int $postId): ?Post;
}
