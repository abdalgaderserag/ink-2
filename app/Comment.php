<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Traits\Post;

    public function replies()
    {
        return $this->hasMany('App\comment');
    }

    public function ink()
    {
        return $this->belongsTo('App\Ink');
    }

    public function parentComment()
    {
        return $this->belongsTo('App\Comment', 'comment_id', 'id');
    }
}
