<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class WeixinController extends Controller {

	//
    public function __construct(){
        //调用中间件,中间件的命名在kernel.php
        $this->middleware('weixinaccesstoken');
        //echo '111';die;
        $this->middleware('checkopenid');
    }

    public function index(Request $request,$openid=''){

       // echo 'weixin';
        //$weixin=$request->session()->get('openid');
        //echo $weixin;

        if($openid==null){
            echo 'no openid';
            $openid=$request->session()->get('openid');

        }else{
            echo $openid;
        }
    }
    
}
