<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
{
    $posts = Post::query();

    // $posts->where('status', 'Published');

    if ($request->filled('search')) {

        $search = $request->search;

        $posts->where(function ($query) use ($search) {

            $query->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%');

        });
    }

    // Sort + Pagination
    $posts = $posts
        ->orderBy('title', 'asc')
        ->paginate(10);

    // Count
    $totalPosts = Post::count();

    $publishedPosts = Post::where('status', 'Published')->count();

    return view('posts.index', compact(
        'posts',
        'totalPosts',
        'publishedPosts'
    ));
}

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
            'status' => $request->status,
        ]);

        return redirect()->route('posts.index');
    }

    public function show(string $id)
{
    $post = Post::findOrFail($id);

    return view('posts.show', compact('post'));
}

    public function edit(string $id)
    {
        $post = Post::findOrFail($id);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'author' => 'required',
            'status' => 'required',
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
            'status' => $request->status,
        ]);

        return redirect()->route('posts.index');
    }

    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()->route('posts.index');
    }
}