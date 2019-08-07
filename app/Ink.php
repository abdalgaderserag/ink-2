<?php

namespace App;

use App\Traites\Post\Post;
use Illuminate\Database\Eloquent\Model;

class Ink extends Model
{
    use Post;

    public function ink()
    {
        return $this->hasMany('App\Ink');
    }

    public function getLikeCountAttribute($key)
    {
        return \Illuminate\Support\Facades\DB::table('likes')
            ->where('ink_id', $this->attributes['id'])->count();
    }
}
