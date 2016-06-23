<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Request;
use App\Model\Meeting;
use Input;
use Validator;

use DB;

class MeetingController extends Controller {


    public function __construct(){
        $this->url = url('/Meeting/index');
        //echo $url;
    }

    //列表页
    public function index(){
        //$a=$this->url;
        //echo $a;

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

        $del_id=Input::get('mid');


        $res=DB::table('meeting')->where('m_id',$del_id)->delete();
        //dd($res);
        if($res){
            echo "<script>alert('取消成功');</script>";
            redirect('Meeting/index');
        }else{
            echo "<script>alert('取消失败');</script>";
            redirect('Meeting/index');
        }

    }

    //添加页
    public function add(){

        return view('Meeting/add');
    }


    //添加数据
    public function insert(Request $request){
        //接收
        //$input= Request::all();
        //return $input;


        $this->validate_re($request);

        //插入数据
        $res=Meeting::create($request->all());
        //dd($res);
        if($res){
            echo "<script>alert('预约成功');window.location.href=".$this->url.";</script>";

        }else{
            echo "<script>alert('预约失败');window.history.back(-1);</script>";
        }
    }


    //修改页
    public function update($mid){

        $meeting=DB::table('meeting')->where('m_id',$mid)->first();
        //var_dump($meeting);
        return view('Meeting/update',[

            'meeting'=>$meeting,
        ]);

    }

    //修改数据
    public function save(Request $request){
        //接收
        //$input= Request::all();
        $input=Input::except('_token');
        //var_dump($input);

        $this->validate_re($request);


        $mid=$input['m_id'];
        echo $mid;
        //die;


        //修改数据
        $res=DB::table('meeting')->where('m_id',$mid)->update($input);
        //dd($res);
        if($res){
            echo "<script>alert('预约成功');window.location.href=$this->url;</script>";
        }else{
            echo "<script>alert('预约失败');window.history.back(-1);</script>";
        }

    }

    function validate_re($request){
        $rules = [
            'm_subject'=>'required',
            'm_type'=>'required',
            'm_department'=>'required',
            'm_member'=>'required',
            'm_address'=>'required',
            'm_mc'=>'required',
            'm_author'=>'required',

        ];

        $messages = [
            'm_subject.required' => '请填写会议主题',
            'm_type.required' => '请填写会议类别,例如早会',
            'm_department.required' => '请填写主持部门',
            'm_member.required' => '请填写会议成员',
            'm_address.required' => '请填写会议地点',
            'm_mc.required' => '请填写主持人的名字',
            'm_author.required' => '请填写主讲人的名字',
        ];

        $this->validate($request, $rules,$messages);
    }

}
