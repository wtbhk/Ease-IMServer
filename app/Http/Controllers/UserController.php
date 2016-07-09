<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

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

    public function index()
    {
        return User::all();
    }
}
