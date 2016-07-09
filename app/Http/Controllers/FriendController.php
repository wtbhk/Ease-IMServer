<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;

class FriendController extends Controller
{
    public function index()
    {
        return Auth::user()->friends;
    }

    public function store(Request $request, $phone)
    {
        $user = User::where('phone', $phone)->first();
        if($user) {
            return Auth::user()->friends()->save($user);
        }
    }

    public function delete($phone)
    {
        $id = User::where('phone', $phone)->first()->id;
        return Auth::user()->friends()->detach($id);
    }
}
