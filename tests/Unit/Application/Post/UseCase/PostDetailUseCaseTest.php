<?php

namespace Tests\Unit\Application\Post\UseCase;

use App\Application\Post\UseCase\PostDetailUseCase;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Domain\Post\Entity\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class PostDetailUseCaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 投稿の詳細を取得できること()
    {
        $postRepositoryMock = Mockery::mock(PostRepositoryInterface::class);
        $this->app->instance(PostRepositoryInterface::class, $postRepositoryMock);

        $post = new Post(1, 1, 'Test Title', 'Test Content');
        $postRepositoryMock->shouldReceive('findByIdAndUserId')->once()->andReturn($post);

        $useCase = new PostDetailUseCase($postRepositoryMock);
        $result = $useCase->execute(1, 1);

        $this->assertInstanceOf(Post::class, $result);
        $this->assertEquals('Test Title', $result->getTitle());
        $this->assertEquals('Test Content', $result->getContent());
    }

}
