<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{   
    protected $table = 'student';
    protected $primaryKey = 'student_id';

    protected $fillable = ['meeting_date','meeting_status','lecture_id_FK'];

    public $incrementing = false;
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
