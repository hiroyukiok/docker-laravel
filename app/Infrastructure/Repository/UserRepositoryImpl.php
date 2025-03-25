<?php

namespace App\Infrastructure\Repository;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Models\User as EloquentUser;
use App\Domain\User\ValueObject\Email;

class UserRepositoryImpl implements UserRepositoryInterface
{
    public function save(User $user): void
    {
        $eloquentUser = new EloquentUser();
        $eloquentUser->name = $user->getName();
        $eloquentUser->email = $user->getEmail()->getEmail();
        $eloquentUser->password = $user->getPassword();
        $eloquentUser->save();
    }

    // Userエンティティを返す
    public function findByEmail(string $email): ?User
    {
        $eloquentUser = EloquentUser::where('email', $email)->first();

        if (!$eloquentUser) {
            return null;
        }

        return new User(
            $eloquentUser->id,
            $eloquentUser->name,
            new Email($eloquentUser->email),
            $eloquentUser->password
        );
    }

    // Eloquentモデルを返す認証用のメソッド
    public function getEloquentUserByEmail(string $email): ?\App\Models\User
    {
        return EloquentUser::where('email', $email)->first(); // EloquentのUserモデルを返す
    }

}

