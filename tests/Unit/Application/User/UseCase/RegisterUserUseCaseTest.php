<?php

namespace Tests\Unit\Application\User\UseCase;

use Tests\TestCase;
use App\Application\User\UseCase\RegisterUserUseCase;
use App\Application\User\DTO\UserDTO;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\Email;
use Illuminate\Support\Facades\Hash;
use Mockery;

class RegisterUserUseCaseTest extends TestCase
{
    private $userRepositoryMock;
    private $registerUserUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        // UserRepositoryInterface のモックを作成
        $this->userRepositoryMock = Mockery::mock(UserRepositoryInterface::class);

        // RegisterUserUseCase にモックを注入
        $this->registerUserUseCase = new RegisterUserUseCase($this->userRepositoryMock);
    }

    /** @test */
    public function ユーザーが正常に登録されること()
    {
        $userDTO = new UserDTO('Test User', 'test@example.com', 'password123');

        // `save` メソッドが適切に呼ばれることを確認
        $this->userRepositoryMock
            ->shouldReceive('save')
            ->once()
            ->with(Mockery::on(function ($user) use ($userDTO) {
                return $user instanceof User
                    && $user->getName() === $userDTO->getName()
                    && $user->getEmail()->getEmail() === $userDTO->getEmail()  // Email オブジェクトの内部値を取得
                    && Hash::check($userDTO->getPassword(), $user->getPassword()); // パスワードが正しくハッシュ化されているかチェック
            }))
            ->andReturn(true);

        // 実行
        $this->registerUserUseCase->execute($userDTO);

        $this->assertTrue(true); // 例外が発生しなければOK
    }


    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
