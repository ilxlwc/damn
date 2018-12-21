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

	public function update_orders(Request $request)
	{
		$id = request('id');
		$prepare_amount = request('prepare_amount');
		$service_type = request('service_type');
		$charge = request('charge');
		$returnfee = request('returnfee');
		$assess_source = request('assess_source');
		$assess_unit_price = request('assess_unit_price');
		$assess_gross_amount = request('assess_gross_amount');
		$name = request('name');
		$age = request('age');
		$gender = request('gender');
		$idcard = request('idcard');
		$tel = request('tel');
		$marital_status = request('marital_status');
		$coborrower_name = request('coborrower_name');
		$coborrower_gender = request('coborrower_gender');
		$coborrower_relation = request('coborrower_relation');
		$coborrower_idcard = request('coborrower_idcard');
		$coborrower_tel = request('coborrower_tel');
		$credit_record = request('credit_record');
		$credit_record_status = request('credit_record_status');
		$overdue = request('overdue');
		$house_type = request('house_type');
		$house_owner_certificate = request('house_owner_certificate');
		$owner_type = request('owner_type');
		$house_address = request('house_address');

		Order::where('id', $id)
		->update(['prepare_amount' => $prepare_amount, 'service_type' => $service_type, 'charge' => $charge, 'returnfee' => $returnfee, 'assess_source' => $assess_source, 'assess_unit_price' => $assess_unit_price, 'assess_gross_amount' => $assess_gross_amount, 'name' => $name, 'age' => $age, 'gender' => $gender, 'idcard' => $idcard, 'tel' => $tel, 'marital_status' => $marital_status, 'coborrower_name' => $coborrower_name, 'coborrower_gender' => $coborrower_gender, 'coborrower_relation' => $coborrower_relation, 'coborrower_idcard' => $coborrower_idcard, 'coborrower_tel' => $coborrower_tel, 'credit_record' => $credit_record, 'credit_record_status' => $credit_record_status, 'overdue' => $overdue, 'house_type' => $house_type, 'house_owner_certificate' => $house_owner_certificate, 'owner_type' => $owner_type, 'house_address' => $house_address]);

		return response()->json($orders, 200);
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
                $img_path = '/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$file_name;
                $data = [
                    //'domain_img_path'=>get_domain().$img_path,
                    'domain_img_path'=>$img_path,
                    'img_path'=>$img_path,
                ];
                return response()->json($data, 200);
            }else{
                return response()->json("图片上传失败！", 400);
            }
        }else{
            return response()->json("图片上传失败！", 400);
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
		$attachments = Attachment::where('order_id', $id)->orderBy('file_desc')->get();
		return response()->json([$order, $attachments], 200);
	}
}