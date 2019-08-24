<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Chat extends Model
{
    use Notifiable;

    public function notifications()
    {
        return $this->morphMany(DatabaseMessage::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function first()
    {
        return $this->belongsTo('App\User', 'first_id', 'id');
    }

    public function second()
    {
        return $this->belongsTo('App\User', 'second_id', 'id');
    }
}
