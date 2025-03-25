<?php

namespace App\Infrastructure\Repository;

use App\Domain\Post\Entity\Post;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Models\Post as PostModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Exceptions\PostSaveException;

class PostRepositoryImpl implements PostRepositoryInterface
{
    /**
     * 投稿をEntityに変換する
     */
    private function convertToEntity(PostModel $postModel): Post
    {
        return new Post(
            $postModel->id,
            $postModel->user_id,
            $postModel->title,
            $postModel->content
        );
    }

    /**
     * ユーザーIDに基づいて複数の投稿を取得（ページング対応）
     *
     * @param int $userId
     * @param int $perPage ページあたりの投稿数（デフォルトは10）
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getEloquentPostByUserId(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return PostModel::with('user') // User モデルをリレーションとして一緒に取得
            ->where('user_id', $userId)
            ->paginate($perPage); // ページネーション付きで取得
    }


    /**
     * ユーザーIDに基づいて複数の投稿を取得（ページング対応）
     *
     * @param int $userId
     * @param int $perPage
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function findByUserId(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        $paginator = $this->getEloquentPostByUserId($userId, $perPage);

        // ページング結果のデータを Entity に変換
        $posts = $paginator->getCollection()->map(function ($postModel) {
            return $this->convertToEntity($postModel);
        });

        // 変換後のデータを含めた LengthAwarePaginator を返す
        return new LengthAwarePaginator(
            $posts,
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }






    /**
     * ユーザーIDと投稿IDに基づいて単一の投稿を取得（Eloquent）
     *
     * @param int $id
     * @param int $userId
     * @return \App\Models\Post|null
     */
    public function getEloquentByIdAndUserId(int $id, int $userId): ?\App\Models\Post
    {
        // リレーションを含めて投稿を取得
        return PostModel::with('user') // user リレーションを含めて取得
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * ユーザーIDと投稿IDに基づいて単一の投稿を取得（エンティティ）
     *
     * @param int $id
     * @param int $userId
     * @return Post|null
     */
    public function findByIdAndUserId(int $userId ,int $postId): ?Post
    {
        // Eloquentで投稿とユーザー情報を取得
        $postModel = $this->getEloquentByIdAndUserId($userId, $postId);

        // 投稿が見つからなかった場合はnullを返す
        if (!$postModel) {
            return null;
        }
        // dd($postModel);
        // 取得した Eloquent モデルをエンティティに変換して返す
        return new Post(
            $postModel->id,
            $postModel->user_id,
            $postModel->title,
            $postModel->content,
            $postModel->user->name
        );

    }


    /**
     * 投稿を削除
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        PostModel::destroy($id);
    }

    /**
     * 投稿を保存（新規作成または更新）
     *
     * @param Post $post
     * @return Post
     */
    public function save(Post $post): Post
    {
        try {
            if ($post->getId() === null) {
                // 新規作成時（IDがnullの場合）は create() を使う
                $postModel = PostModel::create([
                    'user_id' => $post->getUserId(),
                    'title' => $post->getTitle(),
                    'content' => $post->getContent()
                ]);
                
                // IDをエンティティにセット
                $post->setId($postModel->id);
            } else {
                // 更新処理
                $updatedRows = PostModel::where('id', $post->getId())->update([
                    'user_id' => $post->getUserId(),
                    'title' => $post->getTitle(),
                    'content' => $post->getContent()
                ]);

                // 更新が成功したかどうかの確認
                if ($updatedRows === 0) {
                    throw new PostSaveException('Post update failed. No rows were updated.');
                }
            }

            // 新規作成・更新どちらの場合も、更新された Post を返す
            return $post;

        } catch (\Exception $e) {
            // 例外が発生した場合、PostSaveException をスロー
            throw new PostSaveException('Failed to save post: ' . $e->getMessage(), 0, $e);
        }
    }

}
