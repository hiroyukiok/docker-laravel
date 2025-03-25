<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'user_id' => 1, // users テーブルのIDを使用
                'title' => '最初の投稿',
                'content' => 'これは最初の投稿です。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'title' => '二番目の投稿',
                'content' => 'これは二番目の投稿です。',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}