<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class supervisor extends Model
{
    protected $table = 'supervisor';
    protected $primaryKey = 'supervisor_id';

    public $incrementing = false;
}
