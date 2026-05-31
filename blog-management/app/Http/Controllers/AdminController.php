<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
//        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::all();
        $posts = Post::with('user')->get();
        return view('admin.index', compact('users', 'posts'));
    }

    public function approve(Post $post)
    {
        $post->approved = true;
        $post->save();

        return redirect()->route('admin.index');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.index');
    }

    public function destroyPost(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.index');
    }
}
