<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function replies()
    {
        return $this->hasMany('App\comment');
    }

    public function media()
    {
        return $this->hasOne('App\Media');
    }

    public function like()
    {
        return $this->hasMany('App\Like');
    }

    public function ink()
    {
        return $this->belongsTo('App\Ink');
    }

    public function parentComment()
    {
        return $this->belongsTo('App\Comment', 'comment_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }
}
