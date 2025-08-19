<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct() { $this->middleware('auth'); }

    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'content' => ['required','string','max:2000']
        ]);
        $data['user_id'] = Auth::id();
        $data['post_id'] = $post->id;
        Comment::create($data);
        return back()->with('success','Comment added.');
    }

    public function destroy(Comment $comment)
    {
        abort_unless($comment->user_id === Auth::id(), 403);
        $comment->delete();
        return back()->with('success','Comment deleted.');
    }
}
