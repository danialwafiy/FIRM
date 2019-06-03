<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'admin_id';
    public $incrementing = false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
