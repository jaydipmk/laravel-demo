<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::post('logout', [UserController::class, 'logout'])->name('logout');

//    Route::middleware('admin')->group(function () {
        Route::resource('admin/users', AdminController::class);
        Route::resource('admin/posts', AdminController::class);
        Route::post('admin/posts/{post}/approve', [AdminController::class, 'approve'])->name('admin.posts.approve');
//    });
//});
