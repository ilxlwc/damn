<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    
	public function __construct()
	{
	    $this->middleware('guest')->except(['destroy']);
	}
	
    //跳转登录页
    public function create()
	{
		//dd(auth()->check());
		//auth()->logout();
		if(auth()->check()){
			return view('home');
		}
		return view('sessions.login');
	}

	//控制器对登录行为进行处理
	public function store()
	{
	    if (!auth()->attempt(request(['name', 'password']))) {
	        return back()->withErrors([
	            'messages' => '请确保用户名和密码正确!'
	        ]);
	    }
	    return redirect()->home();
	} 

	public function destroy()
	{
	    auth()->logout();
	    return view('sessions.login');
	    //return redirect("login");
	    // 生成重定向...
		//return redirect()->route('login');
	}
}
