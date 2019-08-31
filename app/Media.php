<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class Media extends DatabaseNotification
{
    protected $table = 'media';

    protected $casts = [
        'media' => 'array'
    ];

    protected $fillable = [
        'text', 'media', 'comment_id', 'ink_id', 'message_id',
    ];

    public function validate(Request $request)
    {
        if ($request->text == '' && $request->media == [])
            return response()->json('you should enter some data', 502);
    }

    /**
     * dynamic create the media with out save
     *
     * @param Request $request
     * @return Media
     **/
    public static function setMedia(Request $request)
    {
        $data = [
            'text' => $request->text,
            'media' => $request->media,
            'user_id' => Auth::id(),
        ];
        return new Media($data);
    }

    public function setMediaAttribute($key)
    {
        if ($key == null)
            $this->attributes['media'] = [];
        $this->attributes['media'] = $key;
    }
}
