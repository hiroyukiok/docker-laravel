<?php

namespace App\Domain\User\ValueObject;

use InvalidArgumentException;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format.");
        }
        $this->email = $email;
    }

    public function equals(Email $otherEmail): bool
    {
        return $this->email === $otherEmail->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
