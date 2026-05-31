<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});


//Route::get('register', 'AuthController@index')->name('home');



Route::middleware(['guest:user','prevent-back'])->group(function (){
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login-post', [AuthController::class, 'loginAction'])->name('login-post');
    Route::post('register-post', [AuthController::class, 'registerAction'])->name('register-post');
});


Route::middleware(['auth:user','prevent-back'])->group(function (){
    Route::get('dashboard', [ProfileController::class, 'index'])->name('dashboard');
    Route::get('profile', [ProfileController::class, 'getProfile'])->name('profile');
    Route::post('profile-update', [ProfileController::class, 'updateProfile'])->name('profile-update');
    Route::get('logout', function (){
        Auth::guard('user')->logout();
        return redirect()->route('login');
    })->name('logout');
});
