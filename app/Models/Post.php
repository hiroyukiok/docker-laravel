<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    /**
     * 投稿の所有ユーザー（多対1リレーション）
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
}
