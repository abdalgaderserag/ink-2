<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Media extends Model
{
    protected $fillable = [
        'text', 'media', 'comment_id', 'ink_id',
    ];


    /**
     * dynamic create the media with out save
     *
     * @param Request $request
     * @return Media
    **/
    public static function setMedia(Request $request)
    {
        $mei = '';
        if ($request->media != []) {
            foreach ($request->media as $media) {
                $mei = $mei . $media . ',';
            }
        }


        $data = [
            'text' => $request->text,
            'media' => $mei,
            'user_id' => Auth::id(),
        ];
        return new Media($data);
    }
}
