<?php

namespace App\Exceptions;

use Exception;

class PostSaveException extends Exception
{
    /**
     * PostSaveException constructor.
     *
     * @param string $message エラーメッセージ
     * @param int $code エラーコード（省略可）
     * @param Exception|null $previous 前の例外（省略可）
     */
    public function __construct($message = "投稿の保存に失敗しました。", $code = 0, Exception $previous = null)
    {
        // 親クラスのコンストラクタを呼び出し
        parent::__construct($message, $code, $previous);
    }

    /**
     * エラーメッセージの表示
     *
     * @return string
     */
    public function errorMessage()
    {
        // 親のメッセージを表示（必要に応じてフォーマットを変更）
        return "エラー: {$this->message} (コード: {$this->code})";
    }
}
