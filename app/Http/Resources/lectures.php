<?php

namespace app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class lectures extends JsonResource
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
            'lecture_id'=>$this->lecture_id,
            'name'=>$this->name,
            'status'=>$this->status,
        ];    
    }
}
