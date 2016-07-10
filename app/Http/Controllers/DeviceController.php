<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class DeviceController extends Controller
{
    public function register(Request $request) {
        if(! DB::table('oauth_clients')->where('id', $request->input('client_id'))->get()) {
            return DB::table('oauth_clients')->insert([
                'id' => $request->input('client_id'),
                'secret' => $request->input('client_secret'),
                'name' => $request->input('client_id')
            ]);
        }
    }
}
