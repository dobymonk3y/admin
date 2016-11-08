<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Session;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.profile');
    }

    public function update(Request $request)
    {
        User::where('id','=',Auth::user()->id)->update(['realname'=>$request->input('realname')]);
        Session::flash('updateSuccess','个人资料修改成功!');
        return redirect("/user/profiles");
    }

    public function password()
    {
        return view('admin.user.password');
    }

    public function change(Request $request)
    {
        if (!\Hash::check(\Request::input('password'), Auth::user()->password)){
            Session::flash('changePwdFaild',"输入的原始密码不匹配,请重新输入!");
            return redirect('/user/password');
        }
        User::where('id','=',Auth::user()->id)->update(['password' => bcrypt($request->input('newpassword'))]);
        Session::flash('changePwdSuccess',"密码修改成功, 请牢记您的新密码!");
        return redirect('/user/profiles');
    }
}
