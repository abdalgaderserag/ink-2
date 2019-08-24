<?php

namespace App;


use Illuminate\Notifications\DatabaseNotification;

class DatabaseMessage extends DatabaseNotification
{
    protected $table = 'messages';
}