<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//猛狮路由
//会议模块
Route::get('/','MeetingController@index');//首页

Route::get('Meeting/index','MeetingController@index');//列表
Route::get('Meeting/add','MeetingController@add');//添加页
Route::post('Meeting/insert','MeetingController@insert');//数据插入
Route::get('Meeting/update/{mid}','MeetingController@update');//修改页
Route::post('Meeting/save','MeetingController@save');//数据更新
Route::post('Meeting/delete','MeetingController@delete');//删除页



//签到模块
Route::get('Sign/index/{mid}/{openid}','SignController@index');//签到页
Route::post('Sign/check','SignController@check');//会议签到


//员工模块
Route::get('Staff/index','StaffController@index');//员工列表
Route::get('Staff/add','StaffController@add');//添加员工
Route::post('Staff/insert','StaffController@insert');//添加员工
Route::get('Staff/update/{openid}','StaffController@update');//更新员工
Route::post('Staff/save','StaffController@save');//数据更新


Route::get('Weixin/index','WeixinController@index');