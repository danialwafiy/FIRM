<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class logbook extends Model
{
    protected $fillable = ['title', 'description','date','filename','student_id_FK','lecture_verify','supervisor_verify'];

    protected $table = 'logbook';
    
    protected $primaryKey = 'logbook_id';
}
