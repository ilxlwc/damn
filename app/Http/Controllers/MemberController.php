<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Agent;
use App\Capital;

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
		$clients = Client::latest()->paginate(10);
		return view('member.manage_client', compact('clients'));
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
	        	->where([['name', '=', $client['name']],['tel', '=', $client['tel']],])
	        	->restore();
	        if($agent <= 0){
	    		Agent::create($data);
	    	}
	    }else if(request('identity') == 2){
	    	$capital = Capital::withTrashed()
	        	->where([['name', '=', $client['name']],['tel', '=', $client['tel']],])
	        	->restore();
	        if($capital <= 0){
	    		Capital::create($data);
	    	}
	    }
	    Client::where('id',request('id'))->delete();	//软删除client表中的记录  
		return response()->json(['msg' => request('name')], 200);
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
        ->where([
				    ['name', '=', $agent['name']],
				    ['tel', '=', $agent['tel']],			    
				])
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
	        ->where([['name', '=', $capital['name']],
					    ['tel', '=', $capital['tel']],])
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