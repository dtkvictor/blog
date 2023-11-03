<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\AdminAccess;
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
Route::middleware([Authenticate::class, AdminAccess::class])->group(function() {
    Route::prefix('post')->controller(PostController::class)->group(function() {
        Route::get('/', 'my')->name('post.index');
        Route::get('filter/{any?}', 'my')->where('any', '.*')->name('post.filter');
        Route::post('store', 'store')->name('post.store');    
        Route::match(['put', 'patch'], 'update/{id}', 'update')->name('post.update');    
        Route::delete('destroy/{id}', 'destroy')->name('post.destroy');
    });    

    Route::prefix('category')->controller(CategoryController::class)->group(function() {
        Route::get('/', 'index')->name('category.index');
        Route::get('filter/{any?}', 'index')->where('any', '.*')->name('category.filter');
        Route::post('/store', 'store')->name('category.store');
        Route::match(['put', 'patch'], 'update/{id}', 'update')->name('category.update');
        Route::delete('destroy/{id}', 'destroy')->name('category.destroy');
    });    

    Route::prefix('user')->controller(UserController::class)->group(function() {
        Route::get('/', 'index')->name('user.index');
        Route::get('filter/{any?}', 'index')->where('any', '.*')->name('user.filter');
        Route::post('/store', 'store')->name('user.store');
        Route::match(['put', 'patch'], 'update/{id}', 'update')->name('user.update');
        Route::delete('destroy/{id}', 'destroy')->name('user.destroy');
    });    
    
    //Route::resource('user', UserController::class)->names('user');
    //Route::get('user/filter/{any?}', [UserController::class, 'index'])->name('user.filter');
});

Route::middleware(Authenticate::class)->group(function() {
    Route::resource('comments', CommentsController::class)->names('comments');    
    Route::get('profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('profile/update', [ProfileController::class, 'updateData'])->name('profile.update');
    Route::put('profile/update/password', [ProfileController::class, 'updatePassword'])->name('profile.update.password');
    Route::delete('profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');        
    Route::post('like', [LikeController::class, 'store'])->name('like');    
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

//Public
Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'formRegister'])->name('register');
Route::post('/register', [AuthController::class,'register'])->name('register');

Route::get('/', [PostController::class, 'index'])->name('site.index');
Route::get('/filter/{any?}', [PostController::class, 'index'])->name('site.filter')->where('any', '.*');
Route::get('/show/{slug}', [PostController::class, 'show'])->name('site.show');
