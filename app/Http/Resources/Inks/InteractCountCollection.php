<?php

namespace App\Http\Resources\Inks;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InteractCountCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $send = array();
        $i = 0;
        foreach ($this->collection as $ink) {
            $send[$i] = ['like' => new LikeCount($ink), 'comment' => new CommentCount($ink)];
            $i++;
        }
        return $send;
    }
}
