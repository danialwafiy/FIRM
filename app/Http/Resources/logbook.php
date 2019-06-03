<?php

namespace app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class logbook extends JsonResource
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
            'logbook_id'=>$this->logbook_id,
            'title'=>$this->title,
            'description'=>$this->description,
            'date'=>$this->date,
            'supervisor_verify'=>$this->supervisor_verify,
            'lecture_verify'=>$this->lecture_verify,
            'filename'=>$this->filename
        ];    
    }
}
