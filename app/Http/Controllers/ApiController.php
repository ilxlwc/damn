<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Client;
use App\Agent;
use App\Capital;
use App\Attachment;
use App\Repayment;
use App\Intention;
use App\Introduction;
use Laravuel\LaravelWFC\Collector;

class ApiController extends Controller
{
	//只有授权的用户才能够访问下面的请求
	public function __construct()
	{
	}

	public function apply_order()
	{
		$order = new Order();
		$order->client_id = request('client_id');
		$order->name = request('name');
		$order->tel = request('tel');
		$order->idcard = request('idcard');
		$order->apply_amount = request('apply_amount');
		$order->client_remark = request('client_remark');
		$order->save();
		//return response()->json($order, 200);
		
		//微信小程序模板消息群发
		//https://linux.ctolib.com/laravuel-laravel-wfc.html
		$formId = request('formId');
		$client_openId = Client::select('openId')->where('id', request('client_id'))->first();		
		$collector = new Collector($client_openId['openId']);
		$collector->save($formId);

		return 200;
	}

	public function getUserInfo()
	{
		$userId = request('userId'); //userId 就是那个相对应的client_id 或 agent_id 或 capital_id
		$status = request('status'); //status=0:普通用户; status=1:业务员; status=2:资金方

		if($status == 0){
			$userInfos = Client::select('id','name','tel')->where('id', $userId)->get();
			return response()->json($userInfos, 200);
		}else if($status == 1){
			$userInfos = Agent::select('id','name','tel')->where('id', $userId)->get();
			return response()->json($userInfos, 200);
		}else if($status == 2){
			$userInfos = Capital::select('id','name','tel')->where('id', $userId)->get();
			return response()->json($userInfos, 200);
		}
		return response()->json(['msg' => '获取信息错误'], 400);
	}

	public function changeUserInfo()
	{
		$userId = request('userId'); //userId 就是那个相对应的client_id 或 agent_id 或 capital_id
		$status = request('status'); //status=0:普通用户; status=1:业务员; status=2:资金方 
		$name = request('name');
		$tel = request('tel');

		if($status == 0){
			Client::where('id', $userId)->update(['name' => $name, 'tel' => $tel]);	
			return response()->json(['msg' => '更新成功'], 200);
		}else if($status == 1){
			Agent::where('id', $userId)->update(['name' => $name, 'tel' => $tel]);	
			return response()->json(['msg' => '更新成功'], 200);
		}else if($status == 2){
			Capital::where('id', $userId)->update(['name' => $name, 'tel' => $tel]);	
			return response()->json(['msg' => '更新成功'], 200);
		}	
		return response()->json(['msg' => '更新失败'], 400);
	}

	public function apply_identity()
	{		
		Client::where('id', request('client_id'))->update(['apply_status' => 1,'apply_identity' => request('identity'),'name'=> request('name'),'tel'=> request('tel')]);

		//微信小程序模板消息群发
		//https://linux.ctolib.com/laravuel-laravel-wfc.html
		$formId = request('formId');
		$client = Client::select('openId')->where('id', request('client_id'))->first();		
		$collector = new Collector($client['openId']);
		$collector->save($formId);

		return 200;
	}


	public function client_repayments($client_id)
	{
		$order_id = Order::select('id')->where(['status' => 3,'client_id'=> $client_id])->get();
		//print($order_id);
		$repayments = Repayment::select('id','order_id','status','repay_date','repay_num','repayed_date','repayed_num')->whereIn('order_id', $order_id)->orderBy('repay_date')->get();
		return response()->json($repayments, 200);
	}

	public function agent_orders($agent_id)
	{
		$orders = Order::select('id','client_id','name','tel','status','updated_at')->where([['status','<>','4'],['agent_id','=',$agent_id]])->get();
		return response()->json($orders, 200);
	}

	public function update_orders(Request $request)
	{
		//$data = $request->all();
		//$data = json_decode(request('data'), true);
		
		$data = request('data');
		$id = $data[0]['id'];
		$agent_id = $data[0]['agent_id']; ///////////////////新加

		$prepare_amount = $data[0]['prepare_amount'];
		$service_type = $data[0]['service_type'];
		$charge = $data[0]['charge'];
		$returnfee = $data[0]['returnfee'];
		$assess_source = $data[0]['assess_source'];
		$assess_unit_price = $data[0]['assess_unit_price'];
		$assess_gross_amount = $data[0]['assess_gross_amount'];
		$name = $data[0]['name'];
		$age = $data[0]['age'];
		$gender = $data[0]['gender'];
		$idcard = $data[0]['idcard'];
		$tel = $data[0]['tel'];
		$marital_status = $data[0]['marital_status'];
		$coborrower_name = $data[0]['coborrower_name'];
		$coborrower_gender = $data[0]['coborrower_gender'];
		$coborrower_relation = $data[0]['coborrower_relation'];
		$coborrower_idcard = $data[0]['coborrower_idcard'];
		$coborrower_tel = $data[0]['coborrower_tel'];
		$credit_record = $data[0]['credit_record'];
		$credit_record_status = $data[0]['credit_record_status'];
		$overdue = $data[0]['overdue'];
		$house_type = $data[0]['house_type'];
		$house_owner = $data[0]['house_owner'];  /////////////
		$house_owner_certificate = $data[0]['house_owner_certificate'];
		$owner_type = $data[0]['owner_type'];
		$house_address = $data[0]['house_address'];

		if($id){
			Order::where('id', $id)->update(['status' => 1, 'prepare_amount' => $prepare_amount, 'service_type' => $service_type, 'charge' => $charge, 'returnfee' => $returnfee, 'assess_source' => $assess_source, 'assess_unit_price' => $assess_unit_price, 'assess_gross_amount' => $assess_gross_amount, 'name' => $name, 'age' => $age, 'gender' => $gender, 'idcard' => $idcard, 'tel' => $tel, 'marital_status' => $marital_status, 'coborrower_name' => $coborrower_name, 'coborrower_gender' => $coborrower_gender, 'coborrower_relation' => $coborrower_relation, 'coborrower_idcard' => $coborrower_idcard, 'coborrower_tel' => $coborrower_tel, 'credit_record' => $credit_record, 'credit_record_status' => $credit_record_status, 'overdue' => $overdue,'house_owner' => $house_owner, 'house_type' => $house_type, 'house_owner_certificate' => $house_owner_certificate, 'owner_type' => $owner_type, 'house_address' => $house_address]);

				foreach ($data[1] as &$attachments) {
					$attachments['created_at'] = date("Y-m-d H:i:s");
					$attachments['updated_at'] = date("Y-m-d H:i:s");
				}
				Attachment::insert($data[1]);
		}else{			
			$client = Client::select('id')->where('tel', $tel)->first();
			if(!$client['id']){
				return response()->json(['msg' => '提交的电话不存在'], 400);
			}

			$agent = Agent::select('id','name','tel')->where('id', $agent_id)->first();

			$order = new Order();
			$order->client_id = $client['id'];
			$order->agent_id = $agent['id'];
			$order->agent_name = $agent['name'];
			$order->agent_tel = $agent['tel'];
			$order->status = 1;

			$order->prepare_amount = $prepare_amount;
			$order->service_type = $service_type;
			$order->charge = $charge;
			$order->returnfee = $returnfee;
			$order->assess_source = $assess_source;
			$order->assess_unit_price = $assess_unit_price;
			$order->assess_gross_amount = $assess_gross_amount;
			$order->name = $name;
			$order->age = $age;
			$order->gender = $gender;
			$order->idcard = $idcard;
			$order->tel = $tel;
			$order->marital_status = $marital_status;
			$order->coborrower_name = $coborrower_name;
			$order->coborrower_gender = $coborrower_gender;
			$order->coborrower_relation = $coborrower_relation;
			$order->coborrower_idcard = $coborrower_idcard;
			$order->coborrower_tel = $coborrower_tel;
			$order->credit_record = $credit_record;
			$order->credit_record_status = $credit_record_status;
			$order->overdue = $overdue;
			$order->house_type = $house_type;
			$order->house_owner = $house_owner;
			$order->house_owner_certificate = $house_owner_certificate;
			$order->owner_type = $owner_type;
			$order->house_address = $house_address;

			$order->save();

			$order_id = $order->id;
			foreach ($data[1] as &$attachments) {
				$attachments['order_id'] = $order_id;
				$attachments['created_at'] = date("Y-m-d H:i:s");
				$attachments['updated_at'] = date("Y-m-d H:i:s");
			}
			Attachment::insert($data[1]);
		}
		
		//微信小程序模板消息群发
		//https://linux.ctolib.com/laravuel-laravel-wfc.html
		$formId = request('formId');
		$agent = Agent::select('openId')->where('id', $agent_id)->first();		
		$collector = new Collector($agent['openId']);
		$collector->save($formId);

		return 200;
		//return response()->json("信息提交成功", 200);
	}

	public function upload_image(Request $request)
	{
		$file = request()->file('file');
        if($file->isValid()){
            $ext = $file->getClientOriginalExtension();//文件扩展名
            $file_name = date("YmdHis",time()).'-'.uniqid().".".$ext;//保存的文件名
            if(!in_array($ext,['jpg','jpeg','gif','png']) ) return response()->json(err('文件类型不是图片'));
            //把临时文件移动到指定的位置，并重命名
            $path = public_path().DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d').DIRECTORY_SEPARATOR;
            $bool =  $file->move($path,$file_name);
            if($bool){
                $img_path = 'https://'.$request->server('HTTP_HOST').'/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$file_name;
                // $data = [
                //     //'domain_img_path'=>get_domain().$img_path,
                //     'domain_img_path'=>$img_path,
                //     'img_path'=>$img_path,
                // ];
                return response()->json($img_path, 200);
            }else{
                return 400;
            }
        }else{
            return 400;
        }
	}

	public function approved_orders()
	{
		$orders = Order::latest()->select('id','name','prepare_amount','status','created_at')->whereIn('status', [2, 3])->get();
		return response()->json($orders, 200);
	}

	public function capital_orders($capital_id)
	{
		$orders = Order::select('id','name','approve_amount','repay_status')->where([['status','<>','4'],['capital_id','=',$capital_id]])->get();
		return response()->json($orders, 200);
	}

	public function order_detail($id)
	{
		$order = Order::findOrFail($id);
		$attachments = Attachment::where('order_id', $id)->orderBy('file_type')->get();
		return response()->json([$order, $attachments], 200);
	}

	public function order_intention()
	{
		$intention = new Intention();
		$intention->order_id = request('order_id');
		$intention->capital_id = request('capital_id');
		$intention->email = request('email');
		$intention->save();

		//微信小程序模板消息群发
		//https://linux.ctolib.com/laravuel-laravel-wfc.html
		$formId = request('formId');
		$capital = Capital::select('openId')->where('id', request('capital_id'))->first();		
		$collector = new Collector($capital['openId']);
		$collector->save($formId);

		return 200;
	}

	public function get_introduction()
	{
		$introduction = Introduction::select('desc', 'tel', 'addr', 'linkman', 'email')->where('id', 1)->first();
		return response()->json($introduction, 200);
	}

	public function get_intro_pic()
	{
		$pics = Introduction::latest()->select('id', 'pic')->where('item_type', 1)->get();
		return response()->json($pics, 200);
	}
}