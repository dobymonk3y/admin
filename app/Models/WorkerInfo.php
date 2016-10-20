<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkerInfo extends Model
{
    protected $table = 'by_app_remover_worker';
    //禁用 timestamps
    public $timestamps = false;
}
