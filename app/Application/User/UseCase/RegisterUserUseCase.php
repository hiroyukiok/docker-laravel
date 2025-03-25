<?php

namespace App\Application\User\UseCase;

use App\Application\User\DTO\UserDTO;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\Entity\User;
use App\Domain\User\ValueObject\Email;
use Illuminate\Support\Facades\Hash;

class RegisterUserUseCase
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UserDTO $userDTO): void
    {
        
        $email = new Email($userDTO->email);
        $user = new User(null, $userDTO->name, $email, Hash::make($userDTO->password));

        $this->userRepository->save($user);
    }
}
