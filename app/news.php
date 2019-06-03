<?php

namespace app;

use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    protected $fillable = ['title', 'description','filename','date'];

    protected $table = 'news';
    protected $primaryKey = 'news_id';
}
