<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Comment;
use Auth;

class CommentController extends Controller
{
    public function create(Request $request, $post_id)
    {
        $post = Post::find($post_id);
        $post->comments()->create([
            'user_id' => Auth::user()->id,
            'content' => $request->input('content')
        ]);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if($comment->user_id == Auth::user()->id) {
            return $comment->delete();
        }
    }
}
