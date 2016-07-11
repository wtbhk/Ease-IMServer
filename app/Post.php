<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

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

    public function getImageAttribute($value)
    {
        if (!$value) {
            return '';
        }
        return Storage::disk('qiniu')->getDriver()
            ->imagePreviewUrl($value, 'imageView2/1/w/100/h/100');
    }

}
