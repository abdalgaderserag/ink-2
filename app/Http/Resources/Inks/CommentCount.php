<?php

namespace App\Http\Resources\Inks;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentCount extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->comment->count();
    }
}
