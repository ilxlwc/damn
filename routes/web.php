<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('login');
// });


// 管理员登录
Route::get('/','SessionsController@create');
Route::get('/login','SessionsController@create')->name('login');
Route::post('/submin_login','SessionsController@store');
Route::get('/logout','SessionsController@destroy');
//后台首页
//Route::get('/home','RouteController@home')->name('home');
//管理员管理
Route::get('/manage_admin','AdminController@admin_home');
Route::post('/add_admin','AdminController@add_admin');
Route::post('/change_adminPassword','AdminController@change_adminPassword');
Route::post('/delete_admin','AdminController@delete_admin');
// 成员管理
Route::get('/member','MemberController@client_home');
Route::get('/manage_client','MemberController@client_home');
Route::post('/change_client_identity','MemberController@change_client_identity');
Route::post('/disagree_apply_identity','MemberController@disagree_apply_identity');
Route::get('/manage_agent','MemberController@agent_home');
Route::post('/delete_agent_identity','MemberController@delete_agent_identity');
Route::get('/manage_capital','MemberController@capital_home');
Route::post('/delete_capital_identity','MemberController@delete_capital_identity');

Route::get('/manage_introduction','IntroductionController@manage_introduction');
Route::post('/update_intro_desc','IntroductionController@update_intro_desc');
Route::post('/update_intro_others','IntroductionController@update_intro_others');
Route::post('/delete_intro_pic','IntroductionController@delete_intro_pic');
Route::post('/upload_intro_pic','IntroductionController@upload_intro_pic');


Route::get('/new_order','OrderController@new_order')->name('home');
Route::post('/ignore_order','OrderController@ignore_order');
Route::post('/allot_agent_order','OrderController@allot_agent_order');

Route::get('/checking_order','OrderController@checking_order');
Route::get('/order_detail/{id}','OrderController@order_detail');
Route::get('/change_order_detail/{id}','OrderController@change_order_detail');
Route::post('/sumbit_change_order','OrderController@sumbit_change_order');
Route::post('/to_finding_order','OrderController@to_finding_order');
Route::post('/delete_attachment_order','OrderController@delete_attachment_order');
Route::post('/upload_attachment','OrderController@upload_attachment');


Route::get('/finding_order','OrderController@finding_order');
Route::post('/allot_capital_order','OrderController@allot_capital_order');
Route::post('/get_order_intention','OrderController@get_order_intention');

Route::get('/approved_order','OrderController@approved_order');
Route::post('/repayments_detail','OrderController@repayments_detail');
Route::post('/submit_repayment','OrderController@submit_repayment');
Route::post('/set_repay_status','OrderController@set_repay_status');

