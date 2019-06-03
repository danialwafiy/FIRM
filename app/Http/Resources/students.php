<?php

namespace app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class students extends JsonResource
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
            'student_id'=>$this->student_id,
            'name'=>$this->name,
            'status'=>$this->status,
            'lecture_id_FK'=>$this->lecture_id_FK
        ];    
    }
}
