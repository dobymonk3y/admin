<?php

namespace App\Http\Controllers\Admin;

use App\Models\CarInfo;
use App\Models\CustomService;
use App\Models\OtherCharge;
use App\Models\Paylist;
use App\Models\Cartype;
use App\Models\RemoverOrder;
use App\Models\ServiceCity;
use App\Models\WorkerInfo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect, Input, Auth, Log;

class OrderController extends Controller
{
    public function test(Request $request)
    {
        $phonenum = trim($request->input('phonenum'));
        $data = WorkerInfo::where('w_tel','like','%'.$phonenum.'%')->get();
        if ($data != null) {
            return response()->json(array(
                'status' => 200,
                'data' => $data,
            ));
        } else {
            return response()->json(array(
                'status' => 401,
                'msg'=>'啊哦,~ 没有找到使用这个号码的司机哟,~'
            ));
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = RemoverOrder::where('o_state','>',-1)->orderBy('o_time','DESC')->paginate(5);
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
            //获取车辆信息, 类型, 工作人员价格, 里程价格等信息
            $carinfo = CarInfo::where('car_type_num','=',$v->o_car_inclusive)->first();

            //城市信息相关
            $citysinfo = ServiceCity::where('c_id','=',$v->o_city)->first();

            $orders[$k]['o_num'] = $v->o_num;
            $orders[$k]['o_city'] = $citysinfo->c_name;
            if($v->o_num >7){
                $orders[$k]['o_state'] = '已支付';
            }else{
                $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_single_time_price'] = $v->o_single_time_price ;
            $orders[$k]['o_estimate_price'] = $v->o_estimate_price.'.00';
            $v->o_final_price != 0 ? $v->o_final_price."元" : "0.00元";
            $orders[$k]['o_final_price'] = $v->o_num >= 7 ? $v->o_final_price : "未支付";
            $customServiceInfo = CustomService::where('human_username','=',$v->o_customer_service)->first();
            $orders[$k]['customService'] = $customServiceInfo['human_name'] != null ? $customServiceInfo['human_name'] : "未标注";
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            if($v->o_state > 7 ){
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
        $orders = RemoverOrder::where('o_state','=',1)->orderBy('o_time','DESC')->paginate(5);
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
                $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];//订单状态 汉字
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
            if($v->o_state > 7 ){
                $payinfo = Paylist::where('p_onum','=',$v->o_num)->first();
                $orders[$k]['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
            }else{
                $orders[$k]['payTime'] = "";
            }
            $orders[$k]['o_remark'] = mb_substr($v->o_remark , 0 , 50);
        }
        return view('admin/order/index')->withOrders($orders);
    }

    public function waitOrders()
    {
        $orders = RemoverOrder::whereIn('o_state',[3,4])->orderBy('o_time','DESC')->paginate(5);
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
            if($v->o_state >7){
                $orders[$k]['o_state'] = '已支付';
            }else{
                $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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

    public function removeOrders()
    {
        $orders = RemoverOrder::whereIn('o_state',[5,6])->orderBy('o_time','DESC')->paginate(5);
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
                $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            if($v->o_state > 7 ){
                $payinfo = Paylist::where('p_onum','=',$v->o_num)->first();
                $orders[$k]['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
            }else{
                $orders[$k]['payTime'] = "";
            }
            $orders[$k]['o_remark'] = mb_substr($v->o_remark , 0 , 50);
        }
        return view('admin/order/index')->withOrders($orders);
    }

    public function unpayOrders()
    {
        $orders = RemoverOrder::where('o_state','=',7)->orderBy('o_time','DESC')->paginate(5);
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
                $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            if($v->o_state > 7 ){
                $payinfo = Paylist::where('p_onum','=',$v->o_num)->first();
                $orders[$k]['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
            }else{
                $orders[$k]['payTime'] = "";
            }
            $orders[$k]['o_remark'] = mb_substr($v->o_remark , 0 , 50);
        }
        return view('admin/order/index')->withOrders($orders);
    }

    public function payOrders()
    {
        $orders = RemoverOrder::where('o_state','=',8)->orderBy('o_time','DESC')->paginate(5);
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
                $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            if($v->o_state > 7 ){
                $payinfo = Paylist::where('p_onum','=',$v->o_num)->first();
                $orders[$k]['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
            }else{
                $orders[$k]['payTime'] = "";
            }
            $orders[$k]['o_remark'] = mb_substr($v->o_remark , 0 , 50);
        }
        return view('admin/order/index')->withOrders($orders);
    }

    public function cancelOrders()
    {
        $orders = RemoverOrder::where('o_state','=',9)->orderBy('o_time','DESC')->paginate(5);
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
                $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            if($v->o_state > 7 ){
                $payinfo = Paylist::where('p_onum','=',$v->o_num)->first();
                $orders[$k]['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
            }else{
                $orders[$k]['payTime'] = "";
            }
            $orders[$k]['o_remark'] = mb_substr($v->o_remark , 0 , 50);
        }
        return view('admin/order/index')->withOrders($orders);
    }

    public function showOrder($id)
    {
        $order = RemoverOrder::where('o_num','=',$id)->first();
        if($order == null){
            Session::flash('showOrderFaild',"糟糕！没有查找到订单号为　".$id."　的相关信息！请重新查询！");
            return view('admin.order.show')->withOrder($order);
        }

        //获取车辆信息, 类型, 工作人员价格, 里程价格等信息
        $carinfo = CarInfo::where('car_type_num','=',$order->o_car_inclusive)->first();
        //城市信息相关
        $citysinfo = ServiceCity::where('c_id','=',$order->o_city)->first();
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
        $order['o_num'] = $order->o_num;
        $order['o_city'] = $citysinfo['c_name'];
        if($order->o_num >7){
            $order['o_state'] = '已支付';
        }else{
            $order['state'] = $removestatus[$order->o_state];
        }
        $order['o_driver_grab'] = $order->o_driver_grab == 0 ? "派单" : "抢单";
        $order['o_linkman'] = $order->o_linkman;
        $order['o_linkman_tel'] = $order->o_linkman_tel;
        $order['o_urgent_tel'] = $order->o_urgent_tel;
        $order['o_begin_address'] = mb_substr($order->o_begin_address , 0 , 8);
        $order['o_end_address'] = mb_substr($order->o_end_address , 0 , 8);
        $order['o_time'] = date("Y-m-d H:i",$order->o_time);
        $order['o_mileage'] = $order->o_mileage;
        $order['o_mileage_price'] = $order->o_mileage_price.'.00';
        $order['o_single_time_price'] = $order->o_single_time_price != 0 ? $order->o_single_time_price : "0.00";
        $order['o_estimate_price'] = $order->o_estimate_price.'.00';
        $order->o_final_price != 0 ? $order->o_final_price."元" : "0.00元";
        $order['o_final_price'] = $order->o_state >= 7 ? $order->o_final_price : "";
        $customServiceInfo = CustomService::where('human_username','=',$order->o_customer_service)->first();
        $order['customService'] = $customServiceInfo['human_name'] != null ? $customServiceInfo['human_name'] : "未标注";
        $order['o_worker_name'] = $order->o_state > 2 ? $order->o_worker_name." ( ".$order->o_worker_tel." )" :"";
        $order['o_out_begin_time'] =  $order->o_out_begin_time != null ? date('Y-m-d H:i',$order->o_out_begin_time) : "";
        $order['o_out_end_time'] =  $order->o_out_end_time != null ? date('Y-m-d H:i',$order->o_out_end_time) : "";
        $order['o_in_begin_time'] =  $order->o_in_begin_time != null ? date('Y-m-d H:i',$order->o_in_begin_time) : "";
        $order['o_in_end_time'] =  $order->o_in_end_time != null ? date('Y-m-d H:i',$order->o_in_end_time) : "";
        if($order->o_state > 7 ){
            $payinfo = Paylist::where('p_onum','=',$order->o_num)->first();
            $order['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
        }else{
            $order['payTime'] = "";
        }
        $order['o_remark'] = mb_substr($order->o_remark , 0 , 50);
        if($order['o_other_charge'] > 0){
            $othercharge = OtherCharge::where('c_o_num','=',$order->o_num)->first();
        }else{
            $othercharge = null;
        }
        $payinfo = Paylist::where('p_onum','=',$order->o_state)->first();
        if(!$payinfo == null){
            if($payinfo == 1){
                $payinfo->p_class = '支付宝';
            }elseif($payinfo == 2){
                $payinfo->p_class = '微信';
            }elseif($payinfo == 9){
                $payinfo->p_class = '后台操作支付';
            }else{
                $payinfo->p_class = '未知信息';
            }
        }
//        dd($payinfo);
        return view('admin/order/show')->withOrder($order)->withOthercharge($othercharge)->withPayinfo($payinfo)->withCarinfo($carinfo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = RemoverOrder::where('o_num','=',$id)->first();
        if($order == null){
            Session::flash('showOrderFaild',"糟糕！没有查找到订单号为　".$id."　的相关信息！请重新查询！");
            return view('admin.order.show')->withOrder($order);
        }
        
        //获取车辆信息, 类型, 工作人员价格, 里程价格等信息
        $carinfo = CarInfo::where('car_type_num','=',$order->o_car_inclusive)->first();
        //城市信息相关
        $citysinfo = ServiceCity::where('c_id','=',$order->o_city)->first();
        $citycars = explode(';',$citysinfo->c_inclusive);
        $carcanused = CarInfo::select(['car_type_num','car_name','car_format'])->whereIn('car_type_num',$citycars)->get();
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
        $order['o_num'] = $order->o_num;
        $order['o_city'] = $citysinfo['c_name'];
        $order['o_custom_state'] = $removestatus[$order->o_state];
        $order['o_driver_grab'] = $order->o_driver_grab == 0 ? "派单" : "抢单";
        $order['o_linkman'] = $order->o_linkman;
        $order['o_linkman_tel'] = $order->o_linkman_tel;
        $order['o_urgent_tel'] = $order->o_urgent_tel;
        $order['o_begin_address'] = mb_substr($order->o_begin_address , 0 , 8);
        $order['o_end_address'] = mb_substr($order->o_end_address , 0 , 8);
        $order['o_time'] = date("Y-m-d H:i",$order->o_time);
        $order['o_mileage'] = $order->o_mileage;
        $order['o_mileage_price'] = $order->o_mileage_price.'.00';
        $order['o_single_time_price'] = $order->o_single_time_price != 0 ? $order->o_single_time_price : "0.00";
        $order['o_estimate_price'] = $order->o_estimate_price.'.00';
        $order->o_final_price != 0 ? $order->o_final_price."元" : "0.00元";
        $order['o_final_price'] = $order->o_state >= 7 ? $order->o_final_price : "";
        $customServiceInfo = CustomService::where('human_username','=',$order->o_customer_service)->first();
        $order['customService'] = $customServiceInfo['human_name'] != null ? $customServiceInfo['human_name'] : "未标注";
        $order['o_worker_name'] = $order->o_state > 2 ? $order->o_worker_name." ( ".$order->o_worker_tel." )" :"";
        $order['o_out_begin_time'] =  $order->o_out_begin_time != null ? date('Y-m-d H:i',$order->o_out_begin_time) : "";
        $order['o_out_end_time'] =  $order->o_out_end_time != null ? date('Y-m-d H:i',$order->o_out_end_time) : "";
        $order['o_in_begin_time'] =  $order->o_in_begin_time != null ? date('Y-m-d H:i',$order->o_in_begin_time) : "";
        $order['o_in_end_time'] =  $order->o_in_end_time != null ? date('Y-m-d H:i',$order->o_in_end_time) : "";
        if($order->o_num > 7 ){
            $payinfo = Paylist::where('p_onum','=',$order->o_num)->first();
            $order['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
        }else{
            $order['payTime'] = "";
        }
        $order['o_remark'] = mb_substr($order->o_remark , 0 , 50);
        if($order['o_other_charge'] > 0){
            $othercharge = OtherCharge::where('c_o_num','=',$order->o_num)->first();
        }else{
            $othercharge = null;
        }
        $payinfo = Paylist::where('p_onum','=',$order->o_state)->first();
        if(!$payinfo == null){
            if($payinfo == 1){
                $payinfo->p_class = '支付宝';
            }elseif($payinfo == 2){
                $payinfo->p_class = '微信';
            }elseif($payinfo == 9){
                $payinfo->p_class = '后台操作支付';
            }else{
                $payinfo->p_class = '未知信息';
            }
        }
//        dd($order);
        return view('admin/order/edit')->withOrder($order)->withOthercharge($othercharge)->withPayinfo($payinfo)->withCarinfo($carinfo)->withCarcanused($carcanused);
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
        dd($id);
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
