<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignlog extends Model
{
    protected $table = 'by_app_remover_order_sendrunning';
    //禁用 timestamps
    public $timestamps = false;
}
