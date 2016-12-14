<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customerrecords;
use App\Models\CustomService;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CustomerRecordController extends Controller
{
    public function store(Request $request)
    {
        $num = $request->ordernum;
        $userid = Auth::user()->name;
        $records = $request->remarkcontent;
        $record = new Customerrecords();
        $record->o_num = $num;
        $record->user_id = $userid;
        $record->customer_record = $records;
        $res = $record->save();
        if($res > 0){
            Session::flash('customerRecordAddSuccess','跟进记录已记录!');
            return Redirect::back();
        }else{
            Session::flash('customerRecordAddFail','跟进记录保存失败, 请联系管理员!');
            return Redirect::back();
        }
    }
}
