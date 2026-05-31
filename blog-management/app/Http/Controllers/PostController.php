<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->get();
        return view('post.index', compact('posts'));
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'keywords' => 'required|string|max:255',
            'post_date' => 'required|date',
        ]);

        $post = new Post($request->all());
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'keywords' => 'required|string|max:255',
            'post_date' => 'required|date',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->can_delete) {
            $post->delete();
            return redirect()->route('posts.index');
        }

        return redirect()->route('posts.index')->with('error', "You don't have permission to delete blog");
    }
}
