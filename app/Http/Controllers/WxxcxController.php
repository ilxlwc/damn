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
        //$userInfo = $this->wxxcx->getLoginInfo($code);

        $userInfo = json_decode($this->wxxcx->getUserInfo($encryptedData, $iv));
        $openid = $userInfo['openid'];
        

        if($userId = Client::select('id')->where('openId', $openid)->first()){ //当前登录的是借款人
            $userInfo['status'] = 0;
            $userInfo['userId'] = $userId;
        }
        else if($userId = Agent::select('id')->where('openId', $openid)->first()){ //当前登录的是业务人
            $userInfo['status'] = 1;
            $userInfo['userId'] = $userId;
        }
        else if($userId = Capital::select('id')->where('openId', $openid)->first()){ //当前登录的是资金人
            $userInfo['status'] = 2;
            $userInfo['userId'] = $userId;
        }else{
            $userInfo['status'] = 0;

            $client = new Client();
            $client->avatarUrl = $userInfo['avatarUrl'];
            $client->city = $userInfo['city'];
            $client->province = $userInfo['province'];
            $client->country = $userInfo['country'];
            $client->gender = $userInfo['gender'];
            $client->nickName = $userInfo['nickName'];
            $client->openId = $userInfo['openId'];
            $client->save();

            $userInfo['userId'] = $client->id;
        }

        return response()->json($userInfo, 200);

        //获取解密后的用户信息
        //return $this->wxxcx->getUserInfo($encryptedData, $iv);
    }
}
