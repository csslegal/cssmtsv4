<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'title' => html_entity_decode($this->title),
            'description' => html_entity_decode($this->description),
            'url' => $this->url,
            'content' => html_entity_decode($this->content),
            'image' => $this->image,
            'hit' => $this->hit,
            'botIndex' => $this->bot_index,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
