<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function dashboard()
    {
//        $posts = auth()->user()->posts()->where('approved', true)->get();
        $posts = array();
//        return view('dashboard.dashboard', compact('posts'));
        return view('user.dashboard');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }
}
