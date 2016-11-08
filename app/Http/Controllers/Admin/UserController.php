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
        
    }

    public function change()
    {
        
    }
}
