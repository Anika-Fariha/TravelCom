<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    // show form + list
    public function index()
    {
        $posts = Post::with(['user','likes','comments.user'])
            ->latest()
            ->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'nullable|string|max:255',
        'destination' => 'nullable|string|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ]);

    // If image uploaded, save it
    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('posts', 'public');
    }

    // Create post with ALL validated data
    auth()->user()->posts()->create($validated);

    return redirect()->route('posts.index')->with('success', 'Post created!');
}


    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); // optional Policy; or simple check below
        // if not using policy:
        // abort_unless($post->user_id === Auth::id(), 403);
        $post->delete();
        return back()->with('success','Post deleted.');
    }
}
