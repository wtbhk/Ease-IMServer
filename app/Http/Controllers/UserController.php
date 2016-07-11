<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;
use Storage;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->input();
        return User::create([
            'name' => $data['name'],
            'phone' => $data['username'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function profile()
    {
        return Auth::user();
    }

    public function edit_avatar(Request $request)
    {
        $image_name = 'avatar/'. time() . Auth::user()->id . '.jpg';
        Storage::disk('qiniu')->put(
            $image_name,
            file_get_contents($request->file('avatar')->getRealPath())
        );
        Auth::user()->avatar = $image_name;
        Auth::user()->save();
        return Storage::disk('qiniu')->getDriver()
            ->imagePreviewUrl($image_name, 'imageView2/1/w/100/h/100');
    }

    public function index()
    {
        return User::all();
    }
}
