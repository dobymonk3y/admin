<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherCharge extends Model
{
    protected $table = 'by_app_remover_order_othercharge';
    //禁用 timestamps
    public $timestamps = false;
}
