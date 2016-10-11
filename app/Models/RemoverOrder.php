<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemoverOrder extends Model
{
    protected $table = "by_app_remover_order";
    //禁用 timestamps
    public $timestamps = false;
}
