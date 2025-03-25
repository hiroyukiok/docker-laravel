<?php

namespace Tests\Unit\Domain\User\Repository;

use App\Models\User as EloquentUser; // 正しいインポート

class MockEloquentUser extends EloquentUser
{
    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($id, $name, $email, $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}
