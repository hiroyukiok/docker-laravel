<?php
namespace App\Application\User\UseCase;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUserUseCase
{
    private $userRepository;

    public function __construct($userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $email, string $password): ?\App\Models\User
    {
        // EloquentのUserモデルを取得する
        $eloquentUser = $this->userRepository->getEloquentUserByEmail($email);

        if (!$eloquentUser || !Hash::check($password, $eloquentUser->password)) {
            return null; // 認証失敗
        }

        return $eloquentUser; // EloquentモデルのUserを返す
    }
}
