<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Client;
use App\Agent;
use App\Capital;
use App\Attachment;
use App\Repayment;

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
		//print($order);
		$order->save();
		//return response()->json($order, 200);
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
		$orders = Order::select('id','client_id','status','updated_at')->where([['status','<>','4'],['agent_id','=',$agent_id]])->get();
		return response()->json($orders, 200);
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
		$attachments = Attachment::where('order_id', $id)->orderBy('file_desc')->get();
		return response()->json([$order, $attachments], 200);
	}
}