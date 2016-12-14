<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemoverOrder extends Model
{
    protected $table = "by_app_remover_order";
    //禁用 timestamps
    public $timestamps = false;

    /*
     * 设定修改器
     */

    /*
     * 修改司机端的订单状态
     * 1->开始搬出 2->结束搬出 3->开始搬入 4->结束搬入 6->附加费
     */
    public function getORemoverStateAttribute($value)
    {
        if($value == 1){
            $value = '开始搬出';
        }elseif($value == 2){
            $value = '结束搬出';
        }elseif ($value == 3){
            $value = '开始搬入';
        }elseif ($value == 4){
            $value = '结束搬入';
        }elseif ($value == 4){
            $value = '附加费';
        }
        return $value;
    }
}
