<?php

namespace App\Domain\User\Entity;

use App\Domain\User\ValueObject\Email;

class User
{
    private ?int $id;
    private string $name;
    private Email $email;
    private string $password;

    public function __construct(?int $id, string $name, Email $email, string $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function changeEmail(Email $newEmail): void
    {
        if ($this->email->equals($newEmail)) {
            throw new \DomainException("You cannot change to the same email.");
        }
        $this->email = $newEmail;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
