<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
	//只有授权的用户才能够访问下面的请求
	public function __construct()
	{
	    $this->middleware('auth');
	}
	
    //跳转首页
    public function home()
	{
		return view('home');
	}
}
