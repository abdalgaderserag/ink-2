<?php

namespace App\Traits;

trait Post
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function like()
    {
        return $this->hasMany('App\Like');
    }


    public function media()
    {
        return $this->hasOne('App\Media');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}