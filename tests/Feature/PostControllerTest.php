<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery;
use App\Application\Post\UseCase\CreatePostUseCase;
use App\Application\Post\UseCase\DeletePostUseCase;
use App\Application\Post\UseCase\PostListUseCase;
use App\Application\Post\UseCase\PostDetailUseCase;
use App\Application\Post\DTO\PostDTO;
use App\Domain\Post\Entity\Post;
use App\Domain\User\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User as EloquentUser;
use App\Models\Post as EloquentPost;
use App\Exceptions\UnauthorizedActionException;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    private $createPostUseCase;
    private $deletePostUseCase;
    private $postListUseCase;
    private $postDetailUseCase;

    public function setUp(): void
    {
        parent::setUp();

        // モックの作成
        $this->createPostUseCase = Mockery::mock(CreatePostUseCase::class);
        $this->deletePostUseCase = Mockery::mock(DeletePostUseCase::class);
        $this->postListUseCase = Mockery::mock(PostListUseCase::class);
        $this->postDetailUseCase = Mockery::mock(PostDetailUseCase::class);

        // 依存性をサービスコンテナにバインド
        $this->app->instance(CreatePostUseCase::class, $this->createPostUseCase);
        $this->app->instance(DeletePostUseCase::class, $this->deletePostUseCase);
        $this->app->instance(PostListUseCase::class, $this->postListUseCase);
        $this->app->instance(PostDetailUseCase::class, $this->postDetailUseCase);
    }


    /** @test */
    public function 投稿フォームが表示される()
    {
        $user = EloquentUser::factory()->create(); // 修正

        $response = $this->actingAs($user)->get(route('post.form'));

        $response->assertStatus(200);
        $response->assertViewIs('post.post_form');
    }



    /** @test */
    public function 投稿詳細ページが正しく表示される()
    {
        $user = EloquentUser::factory()->create();
        
        // EloquentPostからPostエンティティに変換
        $eloquentPost = EloquentPost::factory()->create([
            'user_id' => $user->id,
            'title' => 'タイトル',
            'content' => '投稿内容',
        ]);
        
        // EloquentモデルをPostエンティティに変換
        $post = new Post(
            $eloquentPost->id,
            $eloquentPost->user_id,
            $eloquentPost->title,
            $eloquentPost->content,
            $user->name // ユーザー名も渡す場合
        );

        $this->postDetailUseCase
            ->shouldReceive('execute')
            ->with($user->id, $eloquentPost->id)
            ->andReturn($post);

        $response = $this->actingAs($user)->get(route('post.show', ['user_id' => $user->id, 'post_id' => $eloquentPost->id]));

        $response->assertStatus(200);
        $response->assertViewIs('post.post_show');
        $response->assertViewHas('post', $post);
    }



    /** @test */
    public function 投稿詳細ページで記事が見つからない場合は404()
    {
        $user = EloquentUser::factory()->create();
        $this->actingAs($user);

        $this->postDetailUseCase
            ->shouldReceive('execute')
            ->with($user->id, 999)
            ->andReturn(null);

        $response = $this->get(route('post.show', ['user_id' => $user->id, 'post_id' => 999]));

        $response->assertStatus(404);
    }

    /** @test */
    public function 投稿が作成される()
    {
        $user = EloquentUser::factory()->create();
        $this->actingAs($user);

        $postDTO = new PostDTO('タイトル', '投稿内容8文字以上');

        $savedPost = new Post(1, $user->id, $postDTO->title, $postDTO->content); 

        $this->createPostUseCase
            ->shouldReceive('execute')
            ->once()
            ->with(Mockery::on(fn ($arg) => $arg instanceof PostDTO))
            ->andReturn($savedPost);
            

        $response = $this->post(route('post.store'), [
            'title' => 'タイトル',
            'content' => '投稿内容8文字以上',
        ]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success', '投稿が完了しました！');
    }

    /** @test */
    public function 投稿削除が成功する()
    {
        $user = EloquentUser::factory()->create();
        $this->actingAs($user);

        $post = EloquentPost::factory()->create(['user_id' => $user->id]);

        $this->deletePostUseCase
            ->shouldReceive('execute')
            ->once()
            ->with($post->id);

        $response = $this->post(route('post.delete'), ['id' => $post->id]);

        $response->assertRedirect(route('dashboard'));
        $response->assertSessionHas('success', '投稿を削除しました。');
    }

    /** @test */
    public function 自分の投稿以外は削除できない()
    {
        // テストユーザーと他のユーザーを作成
        $user = EloquentUser::factory()->create();
        $otherUser = EloquentUser::factory()->create();

        // 他のユーザーが作成した投稿
        $post = EloquentPost::factory()->create(['user_id' => $otherUser->id]);

        // テストユーザーでログイン
        $this->actingAs($user);

        // DeletePostUseCaseのモックを設定
        $deletePostUseCaseMock = Mockery::mock(DeletePostUseCase::class);
        $deletePostUseCaseMock->shouldReceive('execute')
            ->with($post->id)  // 期待される引数を指定
            ->andThrow(new UnauthorizedActionException('自分の投稿のみ削除できます。'));  // 例外をスロー

        // モックをDIまたはサービスコンテナに登録
        $this->app->instance(DeletePostUseCase::class, $deletePostUseCaseMock);

        // 他人の投稿を削除しようとした場合のテスト
        $response = $this->post(route('post.delete'), ['id' => $post->id]);

        // 302リダイレクトを確認
        $response->assertStatus(302);

        // ダッシュボードにリダイレクトされることを確認
        $response->assertRedirect(route('dashboard'));

        // セッションにエラーメッセージが含まれていることを確認
        $response->assertSessionHas('error', '自分の投稿のみ削除できます。');
    }




    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
