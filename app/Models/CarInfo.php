<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarInfo extends Model
{
    protected $table = 'by_app_remover_inclusive';
    //禁用 timestamps
    public $timestamps = false;
}
