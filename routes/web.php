<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'showDashboard'])->middleware('auth')->name('dashboard');
    Route::get('/post/postform', [PostController::class, 'showPostForm'])->name('post.form'); // 投稿フォーム表示
    Route::post('/post', [PostController::class, 'createPost'])->name('post.store'); // 投稿処理
    Route::post('/post/delete', [PostController::class, 'deletePost'])->name('post.delete');
});

Route::get('/user/{user_id}/post/{post_id}', [PostController::class, 'showPostDetail'])->name('post.show'); // 個別記事表示




Route::get('/', function () {
    // return view('welcome');
    return view('index');
});
