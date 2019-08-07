<?php

namespace App;

use App\Traites\Post\Post;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Post;

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
