<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class WeixinController extends Controller {

	//
    public function _construct(){
        //调用中间件,中间件的命名在kernel.php
        $this->middleware('weixinaccesstoken');
        $this->middleware('checkopenid');
    }

    public function index(){

        echo 'weixin';
    }
    
}
