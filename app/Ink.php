<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ink extends Model
{
    use Traits\Post;

    public function ink()
    {
        return $this->hasMany('App\Ink');
    }
}
