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
        $data = $request->validate([
            'title' => ['nullable','string','max:255'],
            'destination' => ['nullable','string','max:255'],
            'content' => ['required','string','max:5000'],
        ]);
        $data['user_id'] = Auth::id();
        Post::create($data);
        return back()->with('success','Post created.');
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
