<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;

class ListController extends Controller {

	//列表页
    public function index(){
        //echo 'hello';

        $meeting_arr=DB::table('meeting')->orderBy('m_date1','desc')->get();
        //var_dump($meeting_arr);
        //die;

        foreach($meeting_arr as $k=>$v){
            $m_id=$v->m_id;
            $meeting_arr[$k]->member=DB::table('record')->where('m_id',$m_id)->join('staff','record.s_openid','=','staff.s_openid')->get();
            //$member=DB::table('record')->where('m_id',$m_id)->join('staff','record.s_openid','=','staff.s_openid')->get();//测试联表
        }

        //var_dump($member);//测试联表
        //var_dump($meeting_arr);


        //die;
        return view('Meeting/index',[
            'meeting_arr'=>$meeting_arr,

        ]);


    }


   

    

    //删除会议

    public function delete(){


    }

}
