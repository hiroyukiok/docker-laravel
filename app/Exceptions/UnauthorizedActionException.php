<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedActionException extends Exception
{
    // コンストラクタでメッセージを受け取る
    public function __construct($message = '自分の投稿のみ削除できます。', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
