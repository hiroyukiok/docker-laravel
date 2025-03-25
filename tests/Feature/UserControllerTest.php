<?php

namespace Tests\Feature;

use App\Application\User\UseCase\RegisterUserUseCase;
use App\Application\User\UseCase\LoginUserUseCase;
use App\Application\User\UseCase\LogoutUserUseCase;
use App\Application\User\DTO\UserDTO;
use App\Domain\User\Entity\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 
use App\Domain\User\ValueObject\Email;
use App\Models\User as EloquentUser;
use Tests\TestCase;
use Mockery;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $registerUserUseCase;
    private $loginUserUseCase;
    private $logoutUserUseCase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mockを作成
        $this->registerUserUseCase = Mockery::mock(RegisterUserUseCase::class);
        $this->loginUserUseCase = Mockery::mock(LoginUserUseCase::class);
        $this->logoutUserUseCase = Mockery::mock(LogoutUserUseCase::class);

        // DIコンテナにMockをバインド
        $this->app->instance(RegisterUserUseCase::class, $this->registerUserUseCase);
        $this->app->instance(LoginUserUseCase::class, $this->loginUserUseCase);
        $this->app->instance(LogoutUserUseCase::class, $this->logoutUserUseCase);
    }

    /** @test */
    public function 登録入力のバリデーションを確認する()
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    /** @test */
    public function ユーザーを正常に登録できる()
    {
        $userDTO = new UserDTO('Test User', 'test@example.com', 'password123');

        // RegisterUserUseCaseの実行を期待
        $this->registerUserUseCase->shouldReceive('execute')
            ->once()
            ->with(Mockery::on(fn($arg) => $arg instanceof UserDTO))
            ->andReturnNull();

        $response = $this->post('/register', [
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success', '登録が完了しました！ログインしてください。');
    }

    /** @test */
    public function ログイン入力のバリデーションを確認する()
    {
        $response = $this->post('/login', []);

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /** @test */
    public function ユーザーを正常にログインできる()
    {
        $email = 'test@example.com';
        $password = 'password123';
        $hashedPassword = Hash::make($password);

        // テスト用のユーザーをデータベースに作成
        $user = EloquentUser::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => $hashedPassword,
        ]);

        // LoginUserUseCaseのモックを設定
        $this->loginUserUseCase->shouldReceive('execute')
            ->once()
            ->with($email, $password)
            ->andReturn($user);

        // ログインリクエストの送信
        $response = $this->post('/login', [
            'email' => $email,
            'password' => $password,
        ]);

        // リダイレクト先が正しいか確認
        $response->assertRedirect(route('dashboard'));

        // ログイン後、ユーザー情報がセッションに設定されていることを確認
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function 無効な認証情報ではログインに失敗する()
    {
        $email = 'test@example.com';
        $password = 'password123';
        $wrongPassword = 'wrongpassword';

        // テスト用のユーザーをデータベースに作成
        $hashedPassword = Hash::make($password);
        $user = EloquentUser::create([
            'name' => 'Test User',
            'email' => $email,
            'password' => $hashedPassword,
        ]);

        // LoginUserUseCaseのモックを設定
        $this->loginUserUseCase->shouldReceive('execute')
            ->once()
            ->with($email, $wrongPassword)
            ->andReturnNull(); // 認証失敗

        // 無効なパスワードでログインリクエストを送信
        $response = $this->post('/login', [
            'email' => $email,
            'password' => $wrongPassword,
        ]);

        // エラーメッセージが表示されることを確認
        $response->assertSessionHasErrors(['email' => '認証に失敗しました。']);
        
        // リダイレクト先がログインページであることを確認（名前付きルートを使用）
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function ユーザーを正常にログアウトできる()
    {
        // LogoutUserUseCaseの実行を期待
        $this->logoutUserUseCase->shouldReceive('execute')
            ->once()
            ->andReturnNull();

        $response = $this->post('/logout');

        $response->assertRedirect(route('login'));
    }

}
