<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//借款申请
Route::post('apply_order', 'ApiController@apply_order');
//个人借款申请信息
Route::get('client_repayments/{client_id}', 'ApiController@client_repayments');

//业务员订单信息
Route::get('agent_orders/{agent_id}', 'ApiController@agent_orders');
//业务员提交订单信息
Route::post('update_orders', 'ApiController@update_orders');

//申请汇总
Route::get('approved_orders', 'ApiController@approved_orders');
//资方个人中心
Route::get('capital_orders/{capital_id}', 'ApiController@capital_orders');

//资料查看展示
Route::get('order_detail/{id}', 'ApiController@order_detail');