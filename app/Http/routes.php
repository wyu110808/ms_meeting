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

Route::get('/', 'WelcomeController@index');

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
Route::post('articles/add','ArticlesController@add');




