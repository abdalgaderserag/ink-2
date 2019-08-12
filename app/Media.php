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


    public function updateMedia(Request $request)
    {
        $media = $this;
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

        $media->update($data);
        return $media;
    }
}
