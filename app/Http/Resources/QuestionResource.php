<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'content' => $this->content,
            'image' => $this->image,
            'hit' => $this->hit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
