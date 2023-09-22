<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(Authenticate::class)->group(function() {
    Route::resource('comments', CommentsController::class)->names('comments')->except(['show']);
    Route::resource('category', CategoryController::class)->names('category');
    Route::resource('post', PostController::class)->names('post');        
    Route::post('like', [LikeController::class, 'store'])->name('like');    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'formRegister'])->name('register');
Route::post('/register', [AuthController::class,'register'])->name('register');

Route::get('/', [PostController::class, 'index'])->name('post.index');
Route::get('/post', fn() => redirect(route('post.index')));
Route::get('/post/filter/{any?}', [PostController::class, 'index'])->name('post.filter')->where('any', '.*');
Route::get('/post/show/{slug}', [PostController::class, 'show'])->name('post.show');

Route::get('/author', [UserController::class, 'author'])->name('user.author');
Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/comments/{post}', [CommentsController::class, 'show'])->name('comments.show');
