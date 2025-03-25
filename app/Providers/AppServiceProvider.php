<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Application\User\UseCase\RegisterUserUseCase;
use App\Application\User\UseCase\LoginUserUseCase;
use App\Application\User\UseCase\LogoutUserUseCase;
use App\Infrastructure\Repository\UserRepositoryImpl;
use App\Domain\User\Repository\UserRepositoryInterface;

use App\Application\Post\UseCase\DeletePostUseCase;
use App\Domain\Post\Repository\PostRepositoryInterface;
use App\Infrastructure\Repository\PostRepositoryImpl;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepositoryImpl::class);
        $this->app->bind(RegisterUserUseCase::class, function ($app) {
            return new RegisterUserUseCase($app->make(UserRepositoryInterface::class));
        });
        $this->app->bind(LoginUserUseCase::class, function ($app) {
            return new LoginUserUseCase($app->make(UserRepositoryInterface::class));
        });
        $this->app->bind(LogoutUserUseCase::class, function ($app) {
            return new LogoutUserUseCase();
        });

        $this->app->bind(PostRepositoryInterface::class, PostRepositoryImpl::class);
        $this->app->bind(DeletePostUseCase::class, function ($app) {
            return new DeletePostUseCase($app->make(PostRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
