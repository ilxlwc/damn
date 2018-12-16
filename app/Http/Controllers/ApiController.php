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

	//1-1用户申请页
	public function apply_order()
	{
		$order = new Order();
		$order->client_id = request('client_id');
		$order->name = request('name');
		$order->tel = request('tel');
		$order->idcard = request('idcard');
		$order->apply_amount = request('apply_amount');
		$order->client_remark = request('client_remark');
		print($order);
		$order->save();
		//return response()->json($order, 200);
		return 200;
	}
}