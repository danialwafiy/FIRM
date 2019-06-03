<?php

namespace app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class news extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'news_id'=>$this->news_id,
            'title'=>$this->title,
            'description'=>$this->description,
            'date'=>$this->date,
            'filename'=>$this->filename
        ];    
    }
}
