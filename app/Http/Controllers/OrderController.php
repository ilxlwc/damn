<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Client;
use App\Agent;
use App\Capital;
use App\Attachment;
use App\Repayment;

class OrderController extends Controller
{
    //只有授权的用户才能够访问下面的请求
	public function __construct()
	{
	    $this->middleware('auth');
	}

    public function new_order()
	{		
		$clients = Client::select('clients.name', 'clients.tel','orders.id','orders.apply_amount','orders.created_at')->leftJoin('orders','clients.id','=','orders.client_id')->where('status', 0)->paginate(10);
		$agents = Agent::latest()->paginate(10);
		return view('order.new_order',compact('clients','agents'));
	}

	public function checking_order()
	{
		$orders = Order::latest()->where('status', 1)->paginate(10);
		$agents = Agent::latest()->paginate(10);
		return view('order.checking_order',compact('orders','agents'));
	}

	public function ignore_order()
	{
		Order::where('id', request('id'))->update(['status' => 4]);	
		return response()->json(['msg' => request('name')], 200);
	}

	public function allot_agent_order()
	{
		Order::where('id', request('order_id'))
		->update(['status' => 1, 'name' => request('order_name'), 'agent_id' => request('agent_id'), 'agent_name' => request('agent_name'), 'agent_tel' => request('agent_tel')]);
		return response()->json(['order_name' => request('order_name'),
			'agent_name' => request('agent_name'),], 200);
	}

	public function order_detail($id)
	{
		$order = Order::findOrFail($id);
		$attachments = Attachment::where('order_id', $id)->orderBy('file_desc')->get();
		return view('order.order_detail', compact('order','attachments'));
	}

	public function to_finding_order()
	{
		Order::where('id', request('id'))->update(['status' => 2]);	
		return response()->json(['msg' => '提交成功'], 200);
	}

    public function finding_order()
	{
		$orders = Order::latest()->where('status', 2)->paginate(10);
		$capitals = Capital::latest()->paginate(10);
		return view('order.finding_order',compact('orders','capitals'));
	}

	public function allot_capital_order()
	{
		Order::where('id', request('order_id'))
		->update(['status' => 3, 'name' => request('order_name'), 'capital_id' => request('capital_id'), 'capital_name' => request('capital_name'), 'capital_tel' => request('capital_tel'), 'approve_amount' => request('approve_amount')]);
		return response()->json(['order_name' => request('order_name'),
			'capital_name' => request('capital_name'),], 200);
	}

    public function approved_order()
	{
		$orders = Order::latest()->where('status', 3)->paginate(10);		
		return view('order.approved_order',compact('orders','repayments'));
	}

	public function repayments_detail()
	{
		$repayments = Repayment::latest()->where('order_id', request('order_id'))->get();
		return response()->json($repayments);
	}
	
	public function submit_repayment()
	{
		$repayment = new Repayment();
		$repayment->order_id = request('order_id');
		$repayment->repay_num = request('repay_num');
		$repayment->repay_date = request('repay_date');
		$repayment->save();
		return response()->json(['order_name' => request('order_name'),
			'repay_num' => request('repay_num'),], 200);
	}

	public function set_repay_status()
	{
		Order::where('id', request('id'))->update(['repay_status' => 1]);	
		return response()->json(['msg' => request('name')], 200);
	}

}
