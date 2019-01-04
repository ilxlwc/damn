<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Agent;
use App\Capital;
use Laravuel\LaravelWFC\Collector;

class MemberController extends Controller
{
	//只有授权的用户才能够访问下面的请求
	public function __construct()
	{
	    $this->middleware('auth');
	}

	//返回客户首页
    public function client_home()
	{
		$applys = Client::latest()->where('apply_status', 1)->get();
		$clients = Client::latest()->paginate(10);
		return view('member.manage_client', compact('clients','applys'));
	}

	//返回业务员首页
    public function agent_home()
	{
		$agents = Agent::latest()->paginate(10);
		return view('member.manage_agent', compact('agents'));
	}
	
	//返回资金方首页
    public function capital_home()
	{
		$capitals = Capital::latest()->paginate(10);
		return view('member.manage_capital', compact('capitals'));
	}

	//更改用户的身份
	public function change_client_identity()
	{
		
		$this->validate(request(),[
			'id' => 'required',
	        'name' => 'required',
	        'identity' => 'required',
	    ]);
		$client = Client::findorfail(request('id'));
		//更改请求状态码
		Client::where('id', request('id'))->update(['apply_status' => 2]);

		$data =   [
            'name' => $client['name'],
            'tel' => $client['tel'],
            'openId' => $client['openId'],
            'nickName' => $client['nickName'],
            'gender' => $client['gender'],
            'city' => $client['city'],
            'province' => $client['province'],
            'country' => $client['country'],
            'avatarUrl' => $client['avatarUrl'],
            'unionId' => $client['unionId'],
            'appid' => $client['appid'],
        	];
	    if(request('identity') == 1){//变更身份为业务员
	    	//查看软删除中是否有此条记录
	        $agent = Agent::withTrashed()
	        	->where('openId', $client['openId'])
	        	->restore();
	        if($agent <= 0){
	    		Agent::create($data);
	    	}
	    }else if(request('identity') == 2){
	    	$capital = Capital::withTrashed()
	        	->where('openId', $client['openId'])
	        	->restore();
	        if($capital <= 0){
	    		Capital::create($data);
	    	}
	    }
	    Client::where('id',request('id'))->delete();	//软删除client表中的记录

	    try
 		{
		    //微信小程序模板消息群发
			//https://linux.ctolib.com/laravuel-laravel-wfc.html
			$applyType="申请成为业务员已成功";
			if(request('identity') == 2){
				$applyType="申请成为资金方已成功";
			}
		    $collector = new Collector($client['openId']);
			$collector->send($client['openId'], [
			    'template_id' => 'LKwvaScuk9aCGF0xJwRBrAA5z0EzJkMEVsgClklmyzY',
			    'page' => 'pages/index/main',
			    'data' => [
			        'keyword1' => $applyType,
			        'keyword2' => $client['name'],
			        'keyword3' => $client['tel'],
			    ],
			]);

		}		
		catch(Exception $e)
		{
		 echo 'Message: ' .$e->getMessage();
		}

		return response()->json(['msg' => request('name')], 200);
	}

	//不同意用户变更身份申请
	public function disagree_apply_identity()
	{
		$this->validate(request(),['id' => 'required']);
		//更改请求状态码
		Client::where('id', request('id'))->update(['apply_status' => 2]);
		return 200;
	}

	//更改业务员的身份，即将业务员的身份变成普通用户
	public function delete_agent_identity()
	{
		$this->validate(request(),[
			'id' => 'required',
	        'name' => 'required',
	    ]);
		$agent = Agent::findorfail(request('id'));
		//查看软删除中是否有此条记录
        $client = Client::withTrashed()
        ->where('openId', $agent['openId'])
        ->restore();
        if($client <= 0){
        	$data = [
	            'name' => $agent['name'],
	            'tel' => $agent['tel'],
	            'openId' => $agent['openId'],
	            'nickName' => $agent['nickName'],
	            'gender' => $agent['gender'],
	            'city' => $agent['city'],
	            'province' => $agent['province'],
	            'country' => $agent['country'],
	            'avatarUrl' => $agent['avatarUrl'],
	            'unionId' => $agent['unionId'],
	            'appid' => $agent['appid'],
        	];	 
        	Client::create($data);  
        }	    
	    Agent::where('id',request('id'))->delete();	//软删除Agent表中的记录  
		return response()->json(['msg' => request('name')], 200);
	}

	//更改资金方的身份，即将资金方的身份变成普通用户
	public function delete_capital_identity()
	{
		$this->validate(request(),['id' => 'required','name' => 'required']);
		$capital = Capital::findorfail(request('id'));
		//查看软删除中是否有此条记录
        $client = Client::withTrashed()
	        ->where('openId', $capital['openId'])
	        ->restore();
        if($client <= 0){
        	$data = [
	            'name' => $capital['name'],
	            'tel' => $capital['tel'],
	            'openId' => $capital['openId'],
	            'nickName' => $capital['nickName'],
	            'gender' => $capital['gender'],
	            'city' => $capital['city'],
	            'province' => $capital['province'],
	            'country' => $capital['country'],
	            'avatarUrl' => $capital['avatarUrl'],
	            'unionId' => $capital['unionId'],
	            'appid' => $capital['appid'],
        	];	 
        	Client::create($data);  
        }	    
	    Capital::where('id',request('id'))->delete();	//软删除Capital表中的记录  
		return response()->json(['msg' => request('name')], 200);
	}
}