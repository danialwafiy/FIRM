<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class lecture extends Model
{   
    protected $fillable = ['status'];

    protected $table = 'lecture';
    protected $primaryKey = 'lecture_id';

    public $incrementing = false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
