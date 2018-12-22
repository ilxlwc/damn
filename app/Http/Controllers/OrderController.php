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

class OrderController extends Controller
{
    //只有授权的用户才能够访问下面的请求
	public function __construct()
	{
	    $this->middleware('auth');
	}

    public function new_order()
	{
		$clients = Order::latest()->select('id','name','tel','apply_amount','created_at')->where('status', 0)->paginate(10);
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

	public function change_order_detail($id)
	{
		$order = Order::findOrFail($id);
		$attachments = Attachment::where('order_id', $id)->orderBy('file_desc')->get();
		return view('order.change_order_detail', compact('order','attachments'));
	}

	public function sumbit_change_order()
	{
		Order::where('id', request('id'))->update([request('key') => request('value')]);	
		return response()->json(['msg' => '提交成功'], 200);
	}

	public function to_finding_order()
	{
		Order::where('id', request('id'))->update(['status' => 2]);	
		return response()->json(['msg' => '提交成功'], 200);
	}

	public function delete_attachment_order()
	{
		$attachment = Attachment::find(request('id'));
		if($attachment->delete()){
		    return response()->json(['msg' => '删除成功！'], 200);
		}else{
		    return response()->json(['msg' => '删除失败！'], 400);
		}		
	}

	public function upload_attachment(Request $request)
	{
		$img_path = null;
    	if ($request->isMethod('POST')) 
    	{
    		$file = $request->file('fileToUpload');
    		if ($file->isValid()) 
    		{    			
    			$ext = $file->getClientOriginalExtension();
    			$file_name = date("YmdHis",time()).'-'.uniqid().".".$ext;//保存的文件名
	            if(!in_array($ext,['jpg','jpeg','gif','png']) ) return response()->json(err('文件类型不是图片'));
	            //把临时文件移动到指定的位置，并重命名
	            $path = public_path().DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d').DIRECTORY_SEPARATOR;
	            $bool =  $file->move($path,$file_name);
	            if($bool){
	                $img_path = 'https://'.$request->server('HTTP_HOST').'/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$file_name;
	            }
        	}
       	}

       	if($img_path){
       		$file_type = request('file_type');
       		$file_desc = "其它补充材料";
       		switch ($file_type)
			{
				case 0:
				  $file_desc = "身份证"; break;  
				case 1:
				  $file_desc = "户口本"; break;
				case 2:
				  $file_desc = "婚姻证明"; break;
				case 3:
				  $file_desc = "征信记录"; break;
				case 4:
				  $file_desc = "房产证"; break;
				case 5:
				  $file_desc = "营业执照或工作"; break;
				case 6:
				  $file_desc = "流水私发"; break;
				case 7:
				  $file_desc = "评估截图"; break;
				default:
				  $file_desc = "其它补充材料";
			}
       		$attachment = new Attachment();
			$attachment->order_id = request('order_id');
			$attachment->url = $img_path;
			$attachment->file_type = $file_type;
			$attachment->file_desc = $file_desc;
			$attachment->save();
       		return 200;
       	}else{
            	return response()->json("图片上传失败！", 400);
       	}
	}

    public function finding_order()
	{
		$orders = Order::latest()->where('status', 2)->paginate(10);
		$capitals = Capital::latest()->paginate(5);
		return view('order.finding_order',compact('orders','capitals'));
	}

	public function get_order_intention()
	{
		
		$intentions = Intention::where('order_id', request('order_id'))->leftJoin('capitals', 'intentions.capital_id', '=', 'capitals.id')->select('intentions.*','capitals.name','capitals.tel')->get();		
		return response()->json($intentions, 200);
	}

	public function allot_capital_order()
	{
		Order::where('id', request('order_id'))
		->update(['status' => 3, 'name' => request('order_name'), 'capital_id' => request('capital_id'), 'capital_name' => request('capital_name'), 'capital_tel' => request('capital_tel'), 'approve_amount' => request('approve_amount')]);
		
		$repayments = json_decode(request('repayments'),true);
		foreach ($repayments as &$repay) {
			$repay['created_at'] = date("Y-m-d H:i:s");
			$repay['updated_at'] = date("Y-m-d H:i:s");
		}
		Repayment::insert($repayments);
		
		return response()->json(['order_name' => request('order_name'),
			'capital_name' => request('capital_name'),], 200);
	}

    public function approved_order()
	{
		$orders = Order::latest()->where('status', 3)->paginate(10);		
		return view('order.approved_order',compact('orders'));
	}

	public function repayments_detail()
	{
		$repayments = Repayment::latest()->where('order_id', request('order_id'))->get();
		return response()->json($repayments);
	}
	
	public function submit_repayment()
	{		
		Repayment::where('id', request('id'))
		->update(['status' => 1, 'repayed_num' => request('repayed_num'), 'repayed_date' => request('repayed_date')]);
		return response()->json(['repayed_num' => request('repayed_num'),], 200);
	}

	public function set_repay_status()
	{
		Order::where('id', request('id'))->update(['repay_status' => 1]);	
		return response()->json(['msg' => request('name')], 200);
	}

}