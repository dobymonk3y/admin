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
        $res = RemoverOrder::orderBy('o_time','DESC')->paginate(5);
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
            '0' => '待补充',
            '1' => '新订单',
            '3' => '已接受',
            '4' => '已确认',
            '5' => '已出发',
            '6' => '搬家中',
            '7' => '未支付',
            '8' => '待评价',
            '9' => '已结束',
        ];
        $orders = [];
        foreach ($res as $k=>$v){
            $orders[$k]['orderNum'] = $v->o_num;
            $orders[$k]['city'] = $citys[$v->o_city];
            $orders[$k]['removeTime'] = $v->o_remover_date." ".$v->o_remover_clock;
            if($v->o_num >7){
                $orders[$k]['status'] = '已支付';
            }else{
                $orders[$k]['status'] = $removestatus[$v->o_state];
            }
            $orders[$k]['driverGrab'] = $v->o_driver_grab == 0 ? "派单" : "抢单";
            $orders[$k]['name'] = $v->o_linkman;
            $orders[$k]['linkmanTel'] = $v->o_linkman_tel;
            $orders[$k]['urgentTel'] = $v->o_urgent_tel;
            $orders[$k]['beginAddress'] = $v->o_begin_address;
            $orders[$k]['endAddress'] = $v->o_end_address;
            $orders[$k]['orderTime'] = date("Y-m-d H:i:s",$v->o_time);
            $orders[$k]['milage'] = $v->o_mileage;
            $orders[$k]['milageCost'] = $v->o_mileage_price;
            $orders[$k]['singleCost'] = $v->o_single_time_price != 0 ? $v->o_single_time_price : "0.00";
            $orders[$k]['estimateCost'] = $v->o_estimate_price;
            $v->o_final_price != 0 ? $v->o_final_price : "0.00元";
            $orders[$k]['orderCost'] = $v->o_num >7 ? $v->o_final_price : "未支付";
            $customServiceInfo = CustomService::where('human_username','=',$v->o_customer_service)->first();
            $orders[$k]['customService'] = $customServiceInfo['human_name'] != null ? $customServiceInfo['human_name'] : "未标注";
            $orders[$k]['driver'] = $v->o_num > 2 ? $v->o_worker_name."(".$v->o_worker_tel.")" : "";
            $orders[$k]['beginTime'] = $v->o_num > 5 ? $v->o_out_begin_time : "";
            if($v->o_num > 7 ){
                $payinfo = Paylist::where('p_onum','=',$v->o_num)->first();
                $orders[$k]['payTime'] = date("Y-m-d H:i:s",$payinfo['p_time']);
            }else{
                $orders[$k]['payTime'] = "";
            }
        }
//        dd($orders);
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
