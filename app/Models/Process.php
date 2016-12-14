<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table = 'by_running_human_process';
    //禁用 timestamps
    public $timestamps = false;
}
