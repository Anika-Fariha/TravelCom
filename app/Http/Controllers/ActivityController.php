<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    // Feature 4A: posts I liked
    public function likedPosts()
    {
        $posts = Post::whereHas('likes', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->with(['user','likes','comments'])
            ->latest()
            ->paginate(10);
        return view('activity.liked', compact('posts'));
    }

    // Feature 4B: posts I commented
    public function commentedPosts()
    {
        $posts = Post::whereHas('comments', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->with(['user','likes','comments'])
            ->latest()
            ->paginate(10);
        return view('activity.commented', compact('posts'));
    }
}
