<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Introduction;

class IntroductionController extends Controller
{
    //只有授权的用户才能够访问下面的请求
	public function __construct()
	{
	    $this->middleware('auth');
	}

	public function manage_introduction()
	{
		
		return view('member.manage_introduction');
	}

}
