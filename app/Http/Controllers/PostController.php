<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\Post\UseCase\CreatePostUseCase;
use App\Application\Post\UseCase\DeletePostUseCase;
use App\Application\Post\UseCase\PostListUseCase;
use App\Application\Post\UseCase\PostDetailUseCase;
use App\Application\Post\DTO\PostDTO;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\UnauthorizedActionException;
class PostController extends Controller
{
    private CreatePostUseCase $createPostUseCase;
    private DeletePostUseCase $deletePostUseCase;
    private PostListUseCase $postListUseCase;
    private PostDetailUseCase $postDetailUseCase;



    public function __construct(
        CreatePostUseCase $createPostUseCase,
        DeletePostUseCase $deletePostUseCase,
        PostListUseCase $postListUseCase,
        PostDetailUseCase $postDetailUseCase

    ) {
        $this->createPostUseCase = $createPostUseCase;
        $this->deletePostUseCase = $deletePostUseCase;
        $this->postListUseCase = $postListUseCase;
        $this->postDetailUseCase = $postDetailUseCase;

    }

    /**
     * 記事登録フォームの表示
     */
    public function showPostForm()
    {
        return view('post.post_form');
    }

    /**
     * 単体記事の表示
     *
     * @param int $userId
     * @param int $postId
     */
    public function showPostDetail(int $userId, int $postId)
    {
        $post = $this->postDetailUseCase->execute($userId, $postId);

        if (!$post) {
            abort(404, 'Post not found');
        }

        return view('post.post_show', compact('post'));
    }

    /**
     * 記事登録処理
     */
    public function createPost(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:100',
            'content'  => 'required|string|min:8|max:2000',
        ]);

        $postDTO = new PostDTO(
            $request->input('title'),
            $request->input('content')
        );

        // 投稿を作成
        $post = $this->createPostUseCase->execute($postDTO);

        // 投稿後、ダッシュボードにリダイレクト
        return redirect()->route('dashboard')->with('success', '投稿が完了しました！');
    }

    /**
     * 記事削除処理
     */
    public function deletePost(Request $request)
    {

        $request->validate([
            'id' => 'required|integer|exists:posts,id'
        ]);

        try {
            $this->deletePostUseCase->execute($request->input('id'));
            return redirect()->route('dashboard')->with('success', '投稿を削除しました。');
        } catch (UnauthorizedActionException $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'エラーが発生しました。');
        }
    }



}
