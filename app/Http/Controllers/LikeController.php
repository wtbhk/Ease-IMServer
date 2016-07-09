<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class LikeController extends Controller
{
    public function create($post_id)
    {
        return Post::find($post_id)->likedBy()->attach(Auth::user()->id);
    }

    public function delete($post_id)
    {
        return Post::find($post_id)->likedBy()->detach(Auth::user()->id);
    }
}
