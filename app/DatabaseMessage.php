<?php

namespace App;


use Illuminate\Notifications\DatabaseNotification;

class DatabaseMessage extends DatabaseNotification
{
    protected $table = 'messages';

    protected $with = ['media'];

    public function media()
    {
        return $this->hasOne('App\Media', 'message_id', 'id');
    }
}