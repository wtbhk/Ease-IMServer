<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('moments', function() {
    return view('moments');
});

Route::group(['middleware' => ['oauth', 'auth-user']], function() {
    Route::post('friend/{phone}', 'FriendController@store');
    Route::delete('friend/{phone}', 'FriendController@delete');
    Route::get('friend', 'FriendController@index');
    Route::get('profile', 'UserController@profile');
    Route::get('user', 'UserController@index');
    Route::post('avatar', 'UserController@edit_avatar');
    Route::get('post', 'PostController@index');
    Route::post('post', 'PostController@create');
    Route::delete('post/{post_id}', 'PostController@delete');
    Route::post('post/{post_id}/comment', 'CommentController@create');
    Route::delete('comment/{comment_id}', 'CommentController@delete');
    Route::post('post/{post_id}/like', 'LikeController@create');
    Route::delete('post/{post_id}/like', 'LikeController@delete');
});

Route::post('register', 'UserController@register');

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::post('/device', 'DeviceController@register');
