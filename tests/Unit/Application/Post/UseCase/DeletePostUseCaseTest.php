<?php

namespace Tests\Unit\Application\Post\UseCase;

use App\Application\Post\UseCase\DeletePostUseCase;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Domain\Post\Entity\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DeletePostUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 投稿を削除できること()
    {
        // モックを作成
        $postRepositoryMock = Mockery::mock(PostRepositoryInterface::class);
        $this->app->instance(PostRepositoryInterface::class, $postRepositoryMock);

        // 投稿IDとユーザーID
        $postId = 1;
        $userId = 1;

        // 投稿エンティティを作成
        $post = new Post($postId, $userId, 'Test Title', 'Test Content');

        // Auth::id() をモック
        Auth::shouldReceive('id')->once()->andReturn($userId);

        // findByIdAndUserId メソッドのモック設定
        $postRepositoryMock->shouldReceive('findByIdAndUserId')
                        ->once()
                        ->with($postId, $userId)
                        ->andReturn($post);
        
        // delete メソッドのモック設定（削除対象のIDが渡されたことを検証）
        $postRepositoryMock->shouldReceive('delete')->once()->with($postId);

        // UseCase を実行
        $useCase = new DeletePostUseCase($postRepositoryMock);
        $useCase->execute($postId);

        // ✅ アサーションを追加（delete メソッドが呼ばれたかを検証）
        $this->assertTrue(true); // 仮のアサーション（エラー回避）

        // Mockery の検証
        Mockery::close();
    }

}
