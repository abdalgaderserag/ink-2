<?php

namespace App;

use App\Traits\Post;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use Post;

    public function ink()
    {
        return $this->belongsTo('App\Ink');
    }
}
