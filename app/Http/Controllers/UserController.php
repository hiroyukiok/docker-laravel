<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\User\UseCase\RegisterUserUseCase;
use App\Application\User\UseCase\LoginUserUseCase;
use App\Application\User\UseCase\LogoutUserUseCase;
use App\Application\User\DTO\UserDTO;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth; 
use App\Application\Post\UseCase\PostListUseCase;

class UserController extends Controller
{
    private RegisterUserUseCase $registerUserUseCase;
    private LoginUserUseCase $loginUserUseCase;
    private LogoutUserUseCase $logoutUserUseCase;
    private PostListUseCase $postListUseCase;

    public function __construct(
        RegisterUserUseCase $registerUserUseCase,
        LoginUserUseCase $loginUserUseCase,
        LogoutUserUseCase $logoutUserUseCase,
        PostListUseCase $postListUseCase

    ) {
        $this->registerUserUseCase = $registerUserUseCase;
        $this->loginUserUseCase = $loginUserUseCase;
        $this->logoutUserUseCase = $logoutUserUseCase;
        $this->postListUseCase = $postListUseCase;
    }

    /**
     * ユーザー登録フォームの表示
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * ユーザー登録処理
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $userDTO = new UserDTO(
            $request->input('name'),
            $request->input('email'),
            $request->input('password')
        );

        $this->registerUserUseCase->execute($userDTO);

        return redirect()->route('login')->with('success', '登録が完了しました！ログインしてください。');
    }

    /**
     * ログインフォームの表示
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * ログイン処理
     */
    public function login(LoginRequest $request, LoginUserUseCase $loginUserUseCase)
    {
        $validated = $request->validated();

        $email = $validated['email'];
        $password = $validated['password'];

        $user = $loginUserUseCase->execute($email, $password);

        if (!$user) {
            // 失敗した場合は、ログイン画面にリダイレクトしてエラーを表示
            return redirect()->route('login')->withErrors(['email' => '認証に失敗しました。'])->withInput();
        }

        // EloquentUserのインスタンスをAuth::loginに渡す
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * ログアウト処理
     */
    public function logout()
    {
        $this->logoutUserUseCase->execute();
        return redirect()->route('login');
    }

    /**
     * ダッシュボードの表示 (記事一覧)
     */
    public function showDashboard(Request $request)
    {
        $userId = Auth::id(); // ログイン中のユーザーIDを取得
        // ページングを使って投稿一覧を取得
        $posts = $this->postListUseCase->execute($userId, $request->get('perPage', 10));

        // dashboard view にデータを渡して表示

        return view('dashboard', compact('posts'));
    }
}
