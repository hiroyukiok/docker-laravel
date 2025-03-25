<?php

namespace Tests\Unit\Application\Post\UseCase;

use App\Application\Post\UseCase\CreatePostUseCase;
use App\Application\Post\DTO\PostDTO;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Domain\Post\Entity\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use App\Models\User;  // ユーザーのファクトリを使用

class CreatePostUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 投稿を作成できること()
    {
        // 仮のユーザーを作成して認証
        $user = User::factory()->create();  // ユーザーのファクトリを使って作成

        // ユーザーを認証
        $this->actingAs($user);

        // モックを作成
        $postRepositoryMock = Mockery::mock(PostRepositoryInterface::class);
        $this->app->instance(PostRepositoryInterface::class, $postRepositoryMock);

        // データ転送オブジェクト (DTO) を作成
        $postDTO = new PostDTO('Test Title', 'Test Content');

        // 保存後のポストオブジェクトを作成（仮にID 1）
        $savedPost = new Post(1, $user->id, 'Test Title', 'Test Content');  // assuming id 1 and userId

        // モックの挙動を定義（保存メソッドを呼んだら保存後のPostを返す）
        $postRepositoryMock->shouldReceive('save')->once()->andReturn($savedPost);

        // UseCaseを実行
        $useCase = new CreatePostUseCase($postRepositoryMock);
        $result = $useCase->execute($postDTO);

        // 結果の検証
        $this->assertInstanceOf(Post::class, $result);
        $this->assertEquals(1, $result->getId());  // 保存後にIDが設定されていることを確認
        $this->assertEquals('Test Title', $result->getTitle());
        $this->assertEquals('Test Content', $result->getContent());
    }


    // テスト後にMockeryのクリーンアップを行う
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
