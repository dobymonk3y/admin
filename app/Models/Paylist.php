<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paylist extends Model
{
    protected $table = "by_app_paylist";
    public $timestamps = false;

    /*
     * 修改司机端的订单状态
     * 1->开始搬出 2->结束搬出 3->开始搬入 4->结束搬入 6->附加费
     */
    public function getPClassAttribute($value)
    {
        if($value == 1){
            $value = '支付宝';
        }elseif($value == 2){
            $value = '微信';
        }elseif($value == 9){
            $value = '后台操作支付';
        }else{
            $value = '未知信息';
        }
        return $value;
    }
}
