<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\User;
use Auth;
use Storage;

class PostController extends Controller
{
    public function index()
    {
        $friends = Auth::user()->friends->pluck('id');
        $friends[] = Auth::user()->id;
        $posts = Post::with('author')
            ->with('comments.author')
            ->with('likedBy')
            ->whereIn('user_id', $friends)
            ->newest()
            ->get();
        $posts = $posts->map(function ($post, $key) {
            $post->liked = false;
            foreach ($post->likedBy as $user) {
                if ($user->id == Auth::user()->id) {
                    $post->liked = true;
                }
            }
            return $post;
        });
        return $posts;
    }

    public function create(Request $request)
    {
        $image_name = 'images/'. time() . Auth::user()->id . '.jpg';
        Storage::disk('qiniu')->put(
            $image_name,
            file_get_contents($request->file('image')->getRealPath())
        );
        $post = Post::create([
            'image' => $image_name,
            'content' => $request->input('content'),
            'user_id' => Auth::user()->id,
        ]);
        if($request->isJson()) {
            return $post;
        }
        return redirect('/moments/?access_token=' . $request->input('access_token'));
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if($post->user_id == Auth::user()->id) {
            return $post->delete();
        }
    }
}
