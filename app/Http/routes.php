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

/*Route::get('/', 'WelcomeController@index');

Route::get('/home', 'HomeController@index');

// Route::controllers([
// 	'auth' => 'Auth\AuthController',
// 	'password' => 'Auth\PasswordController',
// ]);

//仅作测试
Route::get('test','TestController@index');

//Route::controller('test','TestController');

Route::get('about','PagesController@about');
Route::get('contact','PagesController@contact');

Route::get('articles','ArticlesController@index');
Route::post('articles/add','ArticlesController@add');*/

//猛狮路由
Route::get('/','ListController@index');

Route::get('List','ListController@index');//列表


Route::get('Add/index','AddController@index');//添加页
Route::post('Add/insert','AddController@insert');//数据插入


Route::get('Update','UpdateController@index');//修改页


Route::get('Sign/index/{mid}/{openid}','SignController@index');//签到页
//Route::get('Sign/index/mid/{mid}/openid/{openid}','SignController@index');//签到页

Route::post('Sign/check','SignController@check');//会议签到


//test
Route::get('user/{id}', function($id)
{
    return 'User '.$id;
});
