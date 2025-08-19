<?php
namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    // toggle like/unlike
    public function toggle(Post $post)
    {
        $like = Like::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->first();
        if ($like) {
            $like->delete();
            return back()->with('success','Unliked.');
        }
        Like::create(['user_id' => Auth::id(), 'post_id' => $post->id]);
        return back()->with('success','Liked.');
    }
}
