<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Introduction;

class IntroductionController extends Controller
{
    //只有授权的用户才能够访问下面的请求
	public function __construct()
	{
	    $this->middleware('auth');
	}

	public function manage_introduction()
	{
		$introduction = Introduction::where('id', 1)->first();
		$pics = Introduction::latest()->select('id', 'pic')->where('item_type', 1)->get();
		return view('member.manage_introduction', compact('introduction','pics'));
	}

	public function update_intro_desc()
	{
		Introduction::where('id', 1)->update(['desc' => request('desc')]);	
		return 200;
	}

	public function update_intro_others()
	{
		Introduction::where('id', 1)->update(['tel' => request('tel'),'addr' => request('addr'),'linkman' => request('linkman'),'email' => request('email')]);	
		return 200;
	}

	public function delete_intro_pic()
	{
		$introduction = Introduction::find(request('id'));
		if($introduction->delete()){
		    return response()->json(['msg' => '删除成功！'], 200);
		}else{
		    return response()->json(['msg' => '删除失败！'], 400);
		}
	}

	public function upload_intro_pic(Request $request)
	{
		$img_path = null;
    	if ($request->isMethod('POST')) 
    	{
    		$file = $request->file('fileToUpload');
    		if ($file->isValid()) 
    		{
    			$ext = $file->getClientOriginalExtension();
    			$file_name = date("YmdHis",time()).'-'.uniqid().".".$ext;//保存的文件名
	            if(!in_array($ext,['jpg','jpeg','gif','png']) ) return response()->json(['msg' => '文件类型不是图片'], 400);
	            //把临时文件移动到指定的位置，并重命名
	            $path = public_path().DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.date('Y').DIRECTORY_SEPARATOR.date('m').DIRECTORY_SEPARATOR.date('d').DIRECTORY_SEPARATOR;
	            $bool =  $file->move($path,$file_name);
	            if($bool){
	                $img_path = 'https://'.$request->server('HTTP_HOST').'/uploads/'.date('Y').'/'.date('m').'/'.date('d').'/'.$file_name;
	            }
        	}
       	}
       	if($img_path){
       		$introduction = new Introduction();
			$introduction->item_type = 1;
			$introduction->pic = $img_path;
			$introduction->save();
       		return 200;
       	}
	}



}
