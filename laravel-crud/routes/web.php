<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'index'])->name('user');
Route::get('user', [UserController::class, 'index'])->name('user');
Route::post('user', [UserController::class, 'index'])->name('user');
Route::post('get-user', [UserController::class, 'getUser'])->name('get-user');
// Route::post('user-list', [UserController::class, 'userListDataTable'])->name('user-list');
Route::post('user-edit/{id}', [UserController::class, 'updateUser'])->name('user-edit');
Route::post('user-add', [UserController::class, 'addUser'])->name('user-add');
Route::post('user-delete', [UserController::class, 'destroy'])->name('user-delete');
