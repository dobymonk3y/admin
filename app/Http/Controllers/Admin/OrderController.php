<?php

namespace App\Http\Controllers\Admin;

use App\Models\Assignlog;
use App\Models\CarInfo;
use App\Models\CustomService;
use App\Models\OtherCharge;
use App\Models\Paylist;
use App\Models\Cartype;
use App\Models\RemoverOrder;
use App\Models\ServiceCity;
use App\Models\WorkerInfo;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect, Input, Auth, Log;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function test(Request $request)
    {
        /*$phonenum = trim($request->input('phonenum'));
        $data = WorkerInfo::select(['w_car_plate','w_name','w_tel'])->where('w_tel','=',$phonenum)->get();
        if (count($data)<1){
            return response()->json(array(
                'status' => 402,
                'msg'=>'啊哦,~ 没有找到匹配数据哟,~'
            ));
        }
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
        }*/
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_remover_clock','o_driver_grab','o_state','o_linkman','o_linkman_tel',
            'o_urgent_tel','o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_start_price',
            'o_time_price','o_estimate_price','o_price','o_final_price','o_activity_price','o_worker_name','o_worker_tel',
            'o_out_begin_time','o_remark','o_customer_service'])->where('o_state','>',-1)->orderBy('o_time','DESC')->paginate(5);
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
            $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            //客服人员姓名
            $userinfo = User::where('name','=',$v->o_customer_service)->first();
            if(!empty($userinfo)){
                $orders[$k]['customService'] = $userinfo->realname;
            }else{
                $orders[$k]['customService'] = null;
            }
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

    public function followOrder(Request $request)
    {
        $ordernum = $request->input('ordernumber');
        if(empty($ordernum)){
            Session::flash('noordernum',"参数错误,请联系管理员!");
            return redirect('/orders');
        }
        $userid = Auth::user()->name;
        RemoverOrder::where('o_num','=',$ordernum)->update(['o_customer_service' => $userid]);
        Session::flash('followSuccess',"跟单成功! 请及时跟进订单信息!");
        return redirect('/orders/show/'.$ordernum);
    }

    public function newOrders()
    {
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_remover_clock','o_driver_grab','o_state','o_linkman','o_linkman_tel',
            'o_urgent_tel','o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_start_price',
            'o_time_price','o_estimate_price','o_price','o_final_price','o_activity_price','o_worker_name','o_worker_tel',
            'o_out_begin_time','o_remark','o_customer_service'])->where('o_state','=',1)->orderBy('o_time','DESC')->paginate(5);
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
            $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            //客服人员姓名
            $userinfo = User::where('name','=',$v->o_customer_service)->first();
            if(!empty($userinfo)){
                $orders[$k]['customService'] = $userinfo->realname;
            }else{
                $orders[$k]['customService'] = null;
            }
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
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_remover_clock','o_driver_grab','o_state','o_linkman','o_linkman_tel',
            'o_urgent_tel','o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_start_price',
            'o_time_price','o_estimate_price','o_price','o_final_price','o_activity_price','o_worker_name','o_worker_tel',
            'o_out_begin_time','o_remark','o_customer_service'])->where('o_state','=',3)->orderBy('o_time','DESC')->paginate(5);
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
            $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            //客服人员姓名
            $userinfo = User::where('name','=',$v->o_customer_service)->first();
            if(!empty($userinfo)){
                $orders[$k]['customService'] = $userinfo->realname;
            }else{
                $orders[$k]['customService'] = null;
            }
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

    public function removeOrders()
    {
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_remover_clock','o_driver_grab','o_state','o_linkman','o_linkman_tel',
            'o_urgent_tel','o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_start_price',
            'o_time_price','o_estimate_price','o_price','o_final_price','o_activity_price','o_worker_name','o_worker_tel',
            'o_out_begin_time','o_remark','o_customer_service'])->whereBetween('o_state',[4,6])->orderBy('o_time','DESC')->paginate(5);
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
            $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            //客服人员姓名
            $userinfo = User::where('name','=',$v->o_customer_service)->first();
            if(!empty($userinfo)){
                $orders[$k]['customService'] = $userinfo->realname;
            }else{
                $orders[$k]['customService'] = null;
            }
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
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_remover_clock','o_driver_grab','o_state','o_linkman','o_linkman_tel',
            'o_urgent_tel','o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_start_price',
            'o_time_price','o_estimate_price','o_price','o_final_price','o_activity_price','o_worker_name','o_worker_tel',
            'o_out_begin_time','o_remark','o_customer_service'])->where('o_state','=',7)->orderBy('o_time','DESC')->paginate(5);
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
            $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            //客服人员姓名
            $userinfo = User::where('name','=',$v->o_customer_service)->first();
            if(!empty($userinfo)){
                $orders[$k]['customService'] = $userinfo->realname;
            }else{
                $orders[$k]['customService'] = null;
            }
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
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_remover_clock','o_driver_grab','o_state','o_linkman','o_linkman_tel',
            'o_urgent_tel','o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_start_price',
            'o_time_price','o_estimate_price','o_price','o_final_price','o_activity_price','o_worker_name','o_worker_tel',
            'o_out_begin_time','o_remark','o_customer_service'])->where('o_state','=',8)->orderBy('o_time','DESC')->paginate(5);
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
            $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            //客服人员姓名
            $userinfo = User::where('name','=',$v->o_customer_service)->first();
            if(!empty($userinfo)){
                $orders[$k]['customService'] = $userinfo->realname;
            }else{
                $orders[$k]['customService'] = null;
            }
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
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_remover_clock','o_driver_grab','o_state','o_linkman','o_linkman_tel',
            'o_urgent_tel','o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_start_price',
            'o_time_price','o_estimate_price','o_price','o_final_price','o_activity_price','o_worker_name','o_worker_tel',
            'o_out_begin_time','o_remark','o_customer_service'])->where('o_state','=','-2')->orderBy('o_time','DESC')->paginate(5);
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
            $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            //客服人员姓名
            $userinfo = User::where('name','=',$v->o_customer_service)->first();
            if(!empty($userinfo)){
                $orders[$k]['customService'] = $userinfo->realname;
            }else{
                $orders[$k]['customService'] = null;
            }
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

        //获取车辆信息, 类型, 工作人员价格, 里程价格等信息
        $carinfo = CarInfo::where('car_type_num','=',$order->o_car_inclusive)->first();

        //城市信息相关
        $citysinfo = ServiceCity::where('c_id','=',$order->o_city)->first();

        $order['o_city'] = $citysinfo->c_name;
        $order['o_custom_state'] = $removestatus[$order->o_state];
        $order['o_begin_address'] = mb_substr($order->o_begin_address , 0 , 8);
        $order['o_end_address'] = mb_substr($order->o_end_address , 0 , 8);
        $order['o_time'] = date("Y-m-d H:i",$order->o_time);
        $order['o_mileage_price'] = $order->o_mileage_price.'.00';
        $order['o_estimate_price'] = $order->o_estimate_price.'.00';
        $order->o_final_price != 0 ? $order->o_final_price."元" : "0.00元";
        $order['o_worker_name'] = $order->o_state > 2 ? $order->o_worker_name." ( ".$order->o_worker_tel." )" :"";
        $order['o_out_begin_time'] =  $order->o_out_begin_time != null ? date('Y-m-d H:i',$order->o_out_begin_time) : "";
        $order['o_out_end_time'] =  $order->o_out_end_time != null ? date('Y-m-d H:i',$order->o_out_end_time) : "";
        $order['o_in_begin_time'] =  $order->o_in_begin_time != null ? date('Y-m-d H:i',$order->o_in_begin_time) : "";
        $order['o_in_end_time'] =  $order->o_in_end_time != null ? date('Y-m-d H:i',$order->o_in_end_time) : "";
        //客服人员姓名
        $userinfo = User::where('name','=',$order->o_customer_service)->first();
        if(!empty($userinfo)){
            $order['customService'] = $userinfo->realname;
        }else{
            $order['customService'] = null;
        }
        if($order->o_state > 7 ){
            $payinfo = Paylist::where('p_onum','=',$order->o_num)->first();
            $order['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
        }else{
            $payinfo = '';
            $order['payTime'] = "";
        }
        $order['o_remark'] = mb_substr($order->o_remark , 0 , 50);
        $othercharge = OtherCharge::where('c_o_num','=',$order->o_num)->first();
        return view('admin/order/show')->withOrder($order)->withOthercharge($othercharge)->withCarinfo($carinfo)->withPayinfo($payinfo);
    }

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
        // $carcanused = CarInfo::select(['car_type_num','car_name','car_format'])->whereIn('car_type_num',$citycars)->orderBy('car_type_num','ASC')->get();
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
        $userinfo = User::where('name','=',$order->o_customer_service)->first();
        if(!empty($userinfo)){
            $order['customService'] = $userinfo->realname;
        }else{
            $order['customService'] = null;
        }
        $order['o_worker_name'] = $order->o_worker_name." ( ".$order->o_worker_tel." )";
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
        return view('admin/order/edit')->withOrder($order)->withOthercharge($othercharge)->withPayinfo($payinfo)->withCarinfo($carinfo);
    }

    public function update(Request $request, $id)
    {
        dd($id);
    }

    public function drivers(Request $request)
    {
        $ordernum = trim($request->input('num'));
        $drivers = WorkerInfo::select(['w_name','w_tel','w_car_plate'])->where('w_status','=',1)->paginate(15);
        return view('admin.order.drivers')->withDrivers($drivers)->withOrdernum($ordernum);
    }

    public function driversearch(Request $request)
    {
        $mobile =trim($request->input('mobilenumber'));
        $ordernum = trim($request->input('ordernum'));
        $drivers = WorkerInfo::select(['w_name','w_tel','w_car_plate'])->where('w_status','=',1)->where('w_tel','like','%'.$mobile.'%')->paginate(15);
        return view('admin.order.driversearch')->withDrivers($drivers)->withOrdernum($ordernum)->withMobile($mobile);
    }

    public function assignOrder(Request $request)
    {
        $num = $request->input('num');
        $mobile = $request->input('mobile');
        $data = WorkerInfo::select(['Id','w_car_plate','w_name','w_tel'])->where('w_tel','=',$mobile)->first();
        $oinfo = RemoverOrder::select(['o_remover_num','o_remover_name'])->where('o_num','=',$num)->first();
        RemoverOrder::where('o_num','=',$num)->update([
            'o_worker'=>$data->Id,
            'o_worker_name'=>$data->w_name,
            'o_worker_tel'=>$data->w_tel,
            'o_plate_num'=>$data->w_car_plate,
            'o_driver_grab'=>'2',
            'o_driver_grab_time'=>time(),
        ]);
        Session::flash('orderAssignSuccess','订单指派成功!');
        //将指派信息存储到指派订单表里
        //订单号 当前操作时间 派单人员  派单信息
        // $num $time() Auth::user()->name     Auth::user()->name 将订单 $num 指派给司机 $data->w_name($data->w_tel)
        $assignlog = new Assignlog();
        $assignlog->o_num = $num;
        $assignlog->o_time = time();
        $assignlog->o_user = Auth::user()->name;
        $assignlog->o_action = Auth::user()->realname.'于'.date('Y-m-d H:i:s',time()).'将订单'.$num.'指派给司机'.$data->w_name.'( '.$data->w_tel.' )';
        $assignlog->o_remover_num = $oinfo->o_remover_num;
        $assignlog->o_remover_name = $oinfo->o_remover_name;
        $assignlog->save();
        return Redirect::to('orders/show/'.$num);
    }

    public function search(Request $request)
    {
        $usermobile = trim($request->input('usermobile'));
        $ordernumber = trim($request->input('ordernumber'));
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_remover_clock','o_driver_grab','o_state','o_linkman','o_linkman_tel',
            'o_urgent_tel','o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_start_price',
            'o_time_price','o_estimate_price','o_price','o_final_price','o_activity_price','o_worker_name','o_worker_tel',
            'o_out_begin_time','o_remark','o_customer_service'])->where('o_state','>',0)
            ->Where(function ($um) use ($usermobile) {
                $um->where('o_linkman_tel', 'like', '%'.$usermobile.'%');
            })
            ->Where(function ($on) use ($ordernumber)  {
                $on->where('o_num', 'like', '%'.$ordernumber.'%');
            })
            ->paginate(5);
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
            $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            //客服人员姓名
            $userinfo = User::where('name','=',$v->o_customer_service)->first();
            if(!empty($userinfo)){
                $orders[$k]['customService'] = $userinfo->realname;
            }else{
                $orders[$k]['customService'] = null;
            }
            if($v->o_state > 7 ){
                $payinfo = Paylist::where('p_onum','=',$v->o_num)->first();
                $orders[$k]['payTime'] = date("Y-m-d H:i",$payinfo['p_time']);
            }else{
                $orders[$k]['payTime'] = "";
            }
            $orders[$k]['o_remark'] = mb_substr($v->o_remark , 0 , 50);
        }
        return view('admin.order.search')->withOrders($orders)->withUsermobile($usermobile)->withOrdernumber($ordernumber);
    }

    public function myfollow()
    {
        $orders = RemoverOrder::select(['o_num','o_city','o_remover_date','o_remover_clock','o_driver_grab','o_state','o_linkman','o_linkman_tel',
            'o_urgent_tel','o_begin_address','o_end_address','o_time','o_mileage','o_mileage_price','o_start_price',
            'o_time_price','o_estimate_price','o_price','o_final_price','o_activity_price','o_worker_name','o_worker_tel',
            'o_out_begin_time','o_remark','o_customer_service'])->where('o_state','>',-1)->where('o_customer_service','=',Auth::user()->name)->orderBy('o_time','DESC')->paginate(5);
        //订单状态
        if(empty($orders)){
            // Session::flash('')
            return Redirect::back();
        }
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
            $orders[$k]['o_custom_state'] = $removestatus[$v->o_state];
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
            $orders[$k]['o_worker_name'] = $v->o_state > 2 ? $v->o_worker_name." ( ".$v->o_worker_tel." )" :"";
            $orders[$k]['o_out_begin_time'] =  $v->o_out_begin_time != null ? date('Y-m-d H:i',$v->o_out_begin_time) : "";
            //客服人员姓名
            $userinfo = User::where('name','=',$v->o_customer_service)->first();
            if(!empty($userinfo)){
                $orders[$k]['customService'] = $userinfo->realname;
            }else{
                $orders[$k]['customService'] = null;
            }
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
}
