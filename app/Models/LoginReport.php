<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginReport extends Model
{
    protected $table = 'by_running_human_login';
    //禁用 timestamps
    public $timestamps = false;
}
