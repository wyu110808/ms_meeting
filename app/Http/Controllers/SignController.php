<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;

use App\Model\Record;
use DB;


class SignController extends Controller {

	//签到
    /**
     * @param $mid 会议id
     * @param $openid  会员openid
     */
    public function index($mid,$openid){

        //$mid=$_GET['mid'];
        //$openid=$_GET['openid'];

        //echo $mid.'<br/>'.$openid;


        //检查是否已经签到
        $check_record=DB::table('record')->where('m_id',$mid)->where('s_openid',$openid)->first();
       // var_dump($check_record);
        //die;
        if($check_record){
            $record='existed';
        }else{
            $record='not';
        }

        $meeting_arr=DB::table('meeting')->where('m_id',$mid)->first();

        $meeting_arr->m_date1=date('Y-m-d H:i:s',$meeting_arr->m_date1);
        $meeting_arr->m_date2=date('H:i:s',$meeting_arr->m_date2);

        $member=DB::table('staff')->where('s_openid',$openid)->first();

        //var_dump($meeting_arr);
        //var_dump($member);



        return view('Sign/index',[
            'mid'=>$mid,
            'openid'=>$openid,
            'record'=>$record,
            'meeting'=>$meeting_arr,
            'member'=>$member,
        ]);
    }

    public function check(){

        $input=Request::all();
        //return $input;

        //签到插入数据
        $res=Record::create($input);
        //var_dump($res);
        if($res){
            echo "<script>alert('签到成功');</script>>";
        }
        else{
            echo "<script>alert('签到失败');</script>>";
        }

    }

}
