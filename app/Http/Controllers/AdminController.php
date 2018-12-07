<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{

   	//只有授权的用户才能够访问下面的请求
	public function __construct()
	{
	    $this->middleware('auth');
	}

    //返回管理员首页
    public function admin_home()
	{	    
	    $users =User::latest()->where('name', '<>', 'admin')->paginate(10);
		return view('member.manage_admin',compact('users'));
	}

	// 添加管理员
	public function add_admin()
	{    
	    $this->validate(request(),[
	        'name' => 'required',
	        'password' => 'required|confirmed',
	    ]);

	    try 
		{
		    $user = User::create(request(['name','password']));
		    return response()->json(array('msg'=> $user->name), 200);
		}
		catch(\Exception $e)
		{
		    //return response()->json(array('msg'=> '该用户已存在'), 500);
		    //return response()->with('msg','该用户已存在'), 500);
			return response()->json(['msg' => '该用户已存在'], 500);
		}	   
	}

	//更改管理员密码
	public function change_adminPassword()
	{
		$this->validate(request(),[
			'id' => 'required',
	        'name' => 'required',
	        'password' => 'required|confirmed',
	    ]);
	    User::where('id',request('id'))->update(['password' => bcrypt(request('password'))]);
		return response()->json(['msg' => request('name')], 200);
	}

	//更改管理员密码
	public function delete_admin()
	{
		$this->validate(request(),[
			'id' => 'required',
	        'name' => 'required',
	    ]);
	    User::where('id',request('id'))->delete();
		return response()->json(['msg' => request('name')], 200);
	}
}
