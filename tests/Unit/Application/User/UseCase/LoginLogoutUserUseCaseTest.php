<?php

namespace Tests\Unit\Application\User\UseCase;

use Tests\TestCase;
use App\Application\User\UseCase\LoginUserUseCase;
use App\Application\User\UseCase\LogoutUserUseCase;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\Email;
use Illuminate\Support\Facades\Auth;
use Mockery;

class LoginLogoutUserUseCaseTest extends TestCase
{
    private $userRepositoryMock;
    private $loginUserUseCase;
    private $logoutUserUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->loginUserUseCase = new LoginUserUseCase($this->userRepositoryMock);
        $this->logoutUserUseCase = new LogoutUserUseCase();
    }

    /** @test */
    public function ユーザーが正常にログインできること()
    {
        $email = 'test@example.com';
        $password = 'password123';

        // EloquentUser（App\Models\User）をモック
        $eloquentUser = Mockery::mock(\App\Models\User::class)->makePartial();
        $eloquentUser->shouldReceive('setAttribute')->andReturnSelf();

        $eloquentUser->email = $email;
        $eloquentUser->password = bcrypt($password);

        // getEloquentUserByEmail()のモック
        $this->userRepositoryMock
            ->shouldReceive('getEloquentUserByEmail')
            ->with($email)
            ->andReturn($eloquentUser);

        \Illuminate\Support\Facades\Hash::shouldReceive('check')
            ->with($password, $eloquentUser->password)
            ->andReturn(true);

        $result = $this->loginUserUseCase->execute($email, $password);

        // EloquentUser（App\Models\User）を返すことを確認
        $this->assertInstanceOf(\App\Models\User::class, $result);
    }

    /** @test */
    public function 無効な認証情報でログインに失敗すること()
    {
        $email = 'test@example.com';
        $password = 'wrongpassword';

        // getEloquentUserByEmail()がnullを返す場合のモック
        $this->userRepositoryMock
            ->shouldReceive('getEloquentUserByEmail')
            ->with($email)
            ->andReturn(null);

        $result = $this->loginUserUseCase->execute($email, $password);

        $this->assertNull($result);
    }

    /** @test */
    public function ユーザーが正常にログアウトできること()
    {
        Auth::shouldReceive('logout')
            ->once();

        $this->logoutUserUseCase->execute();

        $this->assertTrue(true); // 例外が発生しなければ成功
    }


    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
