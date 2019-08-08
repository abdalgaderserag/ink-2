<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ink extends Model
{
    use Traits\Post;

    protected $with = ['user', 'media'];


    public function ink()
    {
        return $this->hasMany('App\Ink');
    }
}
