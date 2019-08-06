<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function ink()
    {
        return $this->belongsTo('App\Ink');
    }

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
}
