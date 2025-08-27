<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct() 
    { 
        $this->middleware('auth'); 
    }

    // Show form + list
    public function index()
    {
        $posts = Post::with(['user','likes','comments.user'])
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    // Store new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $validated['image_data'] = file_get_contents($file); // store raw bytes
            $validated['image_name'] = $file->getClientOriginalName(); // store original name
        }

        auth()->user()->posts()->create($validated);

        return redirect()->route('posts.index')->with('success', 'Post created!');
    }

    // Delete post
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete(); // image is in DB, automatically deleted
        return back()->with('success','Post deleted.');
    }
}
