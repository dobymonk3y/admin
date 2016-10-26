<?php

namespace App\Http\Controllers\Admin;

use App\Models\LoginReport;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function login()
    {
        $logins = LoginReport::orderBy('act_time','desc')->paginate(15);
        return view('admin.log.login')->withLogins($logins);
    }
}
