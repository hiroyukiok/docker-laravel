<?php

namespace Tests\Unit\Application\Post\UseCase;

use App\Application\Post\UseCase\PostListUseCase;
use App\Domain\Post\Repository\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class PostListUseCaseTest extends TestCase
{
    /** @test */
    public function ページネーションされた投稿一覧を取得できること()
    {
        $postRepositoryMock = Mockery::mock(PostRepositoryInterface::class);
        $this->app->instance(PostRepositoryInterface::class, $postRepositoryMock);

        $postsPaginator = Mockery::mock(LengthAwarePaginator::class);
        $postRepositoryMock->shouldReceive('findByUserId')->once()->andReturn($postsPaginator);

        $useCase = new PostListUseCase($postRepositoryMock);
        $result = $useCase->execute(1);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

}
