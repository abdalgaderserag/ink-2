<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'user_id', 'follow_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function followers()
    {
        return $this->hasMany('App\User', 'follow_id', 'id');
    }
}
