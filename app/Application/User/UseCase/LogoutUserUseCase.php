<?php

namespace App\Application\User\UseCase;

use Illuminate\Support\Facades\Auth;

class LogoutUserUseCase
{
    public function execute(): void
    {
        Auth::logout();
    }
}
