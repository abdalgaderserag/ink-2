<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ink extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function like()
    {
        return $this->hasMany('App\Like');
    }


    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

    public function ink()
    {
        return $this->hasMany('App\Ink');
    }

    public function media()
    {
        return $this->hasOne('App\Media');
    }

    public function getLikeCountAttribute($key)
    {
        return \Illuminate\Support\Facades\DB::table('likes')
            ->where('ink_id', $this->attributes['id'])->count();
    }
}
