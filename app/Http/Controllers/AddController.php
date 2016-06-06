<?php namespace App\Http\Controllers;

use App\Http\Requests;

use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;

use App\Model\Meeting;

class AddController extends Controller {

	//
    public function index(){
        
        return view('Meeting/add');
    }


    //添加
    public function insert(){
        //接收
        $input= Request::all();
        //return $input;

        //插入数据
        $res=Meeting::create($input);
        dd($res);
    }
}
