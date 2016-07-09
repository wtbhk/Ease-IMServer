<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['content', 'image', 'user_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function likedBy()
    {
        return $this->belongsToMany('App\User', 'likes');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

}
