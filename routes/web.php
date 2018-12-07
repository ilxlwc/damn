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
Route::post('/login','SessionsController@store');
Route::get('/logout','SessionsController@destroy');
//后台首页
Route::get('/home','RouteController@home')->name('home');
// 管理员管理
Route::get('/manage_admin','AdminController@admin_home');
Route::post('/add_admin','AdminController@add_admin');
Route::post('/change_adminPassword','AdminController@change_adminPassword');
Route::post('/delete_admin','AdminController@delete_admin');
// 成员管理
Route::get('/member','MemberController@client_home');
Route::get('/manage_client','MemberController@client_home');
Route::post('/change_client_identity','MemberController@change_client_identity');
Route::get('/manage_agent','MemberController@agent_home');
Route::post('/delete_agent_identity','MemberController@delete_agent_identity');
Route::get('/manage_capital','MemberController@capital_home');
Route::post('/delete_capital_identity','MemberController@delete_capital_identity');

Route::get('/new_order','OrderController@new_order');
Route::post('/ignore_order','OrderController@ignore_order');
Route::post('/allot_agent_order','OrderController@allot_agent_order');

Route::get('/checking_order','OrderController@checking_order');
Route::get('/order_detail/{id}','OrderController@order_detail');
Route::post('/to_finding_order','OrderController@to_finding_order');


Route::get('/finding_order','OrderController@finding_order');
Route::get('/approved_order','OrderController@approved_order');


