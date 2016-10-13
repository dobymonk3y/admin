<?php

namespace App\Http\Controllers\Admin;

use App\Models\CustomService;
use App\Models\Paylist;
use App\Models\RemoverOrder;
use App\Models\ServiceCity;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_state','o_driver_grab','o_linkman','o_linkman_tel','o_urgent_tel',
                                                            'o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_single_time_price','o_worker_name',
                                                            'o_worker_tel','o_out_begin_time',
                                                            'o_estimate_price','o_final_price','o_customer_service','o_remark'])
                        ->where('o_state','>',-1)->orderBy('o_time','DESC')->paginate(5);
        $citysinfo = ServiceCity::all();
        //查询出所有服务中的城市, 区号->城市名
        $citys = array();
        foreach ($citysinfo as $k => $v){
            $citys[$v->c_id]  =  $v->c_name;
        }
        //订单状态
        $removestatus = [
            '-2' => '已删除',
            '-1' => '未生成',
            '1' => '新订单',
            '3' => '已接受',
            '4' => '已确认',
            '5' => '已出发',
            '6' => '搬家中',
            '7' => '已搬完',
            '8' => '已支付',
            '9' => '已结束',
        ];
        foreach ($orders as $k=>$v){
            $orders[$k]['o_num'] = $v->o_num;
            $orders[$k]['o_city'] = $citys[$v->o_city];
            $orders[$k]['o_remover_date'] = $v->o_remover_date." ".$v->o_remover_clock;
            if($v->o_num >7){
                $orders[$k]['o_state'] = '已支付';
            }else{
                $orders[$k]['o_state'] = $removestatus[$v->o_state];
            }
            $orders[$k]['o_driver_grab'] = $v->o_driver_grab == 0 ? "派单" : "抢单";
            $orders[$k]['o_linkman'] = $v->o_linkman;
            $orders[$k]['o_linkman_tel'] = $v->o_linkman_tel;
            $orders[$k]['o_urgent_tel'] = $v->o_urgent_tel;
            $orders[$k]['o_begin_address'] = mb_substr($v->o_begin_address , 0 , 8);
            $orders[$k]['o_end_address'] = mb_substr($v->o_end_address , 0 , 8);
            $orders[$k]['o_time'] = date("Y-m-d H:i",$v->o_time);
            $orders[$k]['o_mileage'] = $v->o_mileage;
            $orders[$k]['o_mileage_price'] = $v->o_mileage_price.'.00';
            $orders[$k]['o_single_time_price'] = $v->o_single_time_price != 0 ? $v->o_single_time_price : "0.00";
            $orders[$k]['o_estimate_price'] = $v->o_estimate_price.'.00';
            $v->o_final_price != 0 ? $v->o_final_price."元" : "0.00元";
            $orders[$k]['o_final_price'] = $v->o_num >7 ? $v->o_final_price : "未支付";
            $customServiceInfo = CustomService::where('human_username','=',$v->o_customer_service)->first();
            $orders[$k]['customService'] = $customServiceInfo['human_name'] != null ? $customServiceInfo['human_name'] : "未标注";
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            if($v->o_num > 7 ){
                $payinfo = Paylist::where('p_onum','=',$v->o_num)->first();
                $orders[$k]['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
            }else{
                $orders[$k]['payTime'] = "";
            }
            $orders[$k]['o_remark'] = mb_substr($v->o_remark , 0 , 50);
        }
        return view('admin/order/index')->withOrders($orders);
    }

    public function newOrders()
    {
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_state','o_driver_grab','o_linkman','o_linkman_tel','o_urgent_tel',
            'o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_single_time_price','o_worker_name',
            'o_worker_tel','o_out_begin_time',
            'o_estimate_price','o_final_price','o_customer_service','o_remark'])
            ->where('o_state','=',1)->orderBy('o_time','DESC')->paginate(5);
        $citysinfo = ServiceCity::all();
        //查询出所有服务中的城市, 区号->城市名
        $citys = array();
        foreach ($citysinfo as $k => $v){
            $citys[$v->c_id]  =  $v->c_name;
        }
        //订单状态
        $removestatus = [
            '-2' => '已删除',
            '-1' => '未生成',
            '1' => '新订单',
            '3' => '已接受',
            '4' => '已确认',
            '5' => '已出发',
            '6' => '搬家中',
            '7' => '已搬完',
            '8' => '已支付',
            '9' => '已结束',
        ];
        foreach ($orders as $k=>$v){
            $orders[$k]['o_num'] = $v->o_num;
            $orders[$k]['o_city'] = $citys[$v->o_city];
            $orders[$k]['o_remover_date'] = $v->o_remover_date." ".$v->o_remover_clock;
            if($v->o_num >7){
                $orders[$k]['o_state'] = '已支付';
            }else{
                $orders[$k]['o_state'] = $removestatus[$v->o_state];
            }
            $orders[$k]['o_driver_grab'] = $v->o_driver_grab == 0 ? "派单" : "抢单";
            $orders[$k]['o_linkman'] = $v->o_linkman;
            $orders[$k]['o_linkman_tel'] = $v->o_linkman_tel;
            $orders[$k]['o_urgent_tel'] = $v->o_urgent_tel;
            $orders[$k]['o_begin_address'] = mb_substr($v->o_begin_address , 0 , 8);
            $orders[$k]['o_end_address'] = mb_substr($v->o_end_address , 0 , 8);
            $orders[$k]['o_time'] = date("Y-m-d H:i",$v->o_time);
            $orders[$k]['o_mileage'] = $v->o_mileage;
            $orders[$k]['o_mileage_price'] = $v->o_mileage_price.'.00';
            $orders[$k]['o_single_time_price'] = $v->o_single_time_price != 0 ? $v->o_single_time_price : "0.00";
            $orders[$k]['o_estimate_price'] = $v->o_estimate_price.'.00';
            $v->o_final_price != 0 ? $v->o_final_price."元" : "0.00元";
            $orders[$k]['o_final_price'] = $v->o_num >7 ? $v->o_final_price : "未支付";
            $customServiceInfo = CustomService::where('human_username','=',$v->o_customer_service)->first();
            $orders[$k]['customService'] = $customServiceInfo['human_name'] != null ? $customServiceInfo['human_name'] : "未标注";
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            if($v->o_num > 7 ){
                $payinfo = Paylist::where('p_onum','=',$v->o_num)->first();
                $orders[$k]['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
            }else{
                $orders[$k]['payTime'] = "";
            }
            $orders[$k]['o_remark'] = mb_substr($v->o_remark , 0 , 50);
        }
        return view('admin/order/index')->withOrders($orders);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
