<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'text', 'media', 'comment_id', 'ink_id',
    ];
}
