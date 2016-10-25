<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
    protected $table = 'by_human';
    //禁用 timestamps
    public $timestamps = false;
}
