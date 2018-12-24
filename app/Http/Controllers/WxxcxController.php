<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Iwanli\Wxxcx\Wxxcx;
use App\Client;
use App\Agent;
use App\Capital;

class WxxcxController extends Controller
{
    protected $wxxcx;

    function __construct(Wxxcx $wxxcx)
    {
        $this->wxxcx = $wxxcx;
    }

    /**
     * 小程序登录获取用户信息
     * @return [type] [description]
     */
    public function getWxUserInfo()
    {
        //code 在小程序端使用 wx.login 获取
        $code = request('code', '');
        //encryptedData 和 iv 在小程序端使用 wx.getUserInfo 获取
        $encryptedData = request('encryptedData', '');
        $iv = request('iv', '');

        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($code);

        //return $this->wxxcx->getUserInfo($encryptedData, $iv);        

        $infos = $this->wxxcx->getUserInfo($encryptedData, $iv);
        $data = json_decode($infos, true);
        $openid = $data["openId"];
        $data['oldUser'] = 0;//老用户

        if($userId = Client::select('id','tel')->where('openId', $openid)->first()){ //当前登录的是借款人
            $data['status'] = 0;
            if($userId['tel']){
                $data['oldUser'] = 1;//老用户
            }
            $data['userId'] = $userId['id'];
        }
        else if($userId = Agent::select('id','tel')->where('openId', $openid)->first()){ //当前登录的是业务人
            $data['status'] = 1;
            if($userId['tel']){
                $data['oldUser'] = 1;//老用户
            }
            $data['userId'] = $userId['id'];
        }
        else if($userId = Capital::select('id','tel')->where('openId', $openid)->first()){ //当前登录的是资金人
            $data['status'] = 2;
            if($userId['tel']){
                $data['oldUser'] = 1;//老用户
            }
            $data['userId'] = $userId['id'];
        }else{
            $data['status'] = 0;

            $client = new Client();
            $client->avatarUrl = $data['avatarUrl'];
            $client->city = $data['city'];
            $client->province = $data['province'];
            $client->country = $data['country'];
            $client->gender = $data['gender'];
            $client->nickName = $data['nickName'];
            $client->openId = $data['openId'];
            $client->save();

            $data['userId'] = $client->id;
        }

        return response()->json($data, 200);

        //获取解密后的用户信息
        //return $this->wxxcx->getUserInfo($encryptedData, $iv);
    }
}
