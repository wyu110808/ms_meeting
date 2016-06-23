<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\Staff;
use DB;
use Input;

class StaffController extends Controller {

    protected $url='/Staff/index';

    public function __construct(){
        //调用中间件,中间件的命名在kernel.php
        $this->middleware('weixinaccesstoken');
        //echo '111';die;
        $this->middleware('checkopenid');
    }

	//员工列表
    public function index(){

        $staff_arr=DB::table('staff')->get();

        return view('Staff/index',[
            'staff_arr'=>$staff_arr,

        ]);
    }


    public function add(){
        //$this->middleware('')
        return view('Staff/add');

    }

    public function insert(Request $request){

        //接收
        //$input= Request::all();

        //$this->validate($request,['s_name'=>'required','s_department'=>'required']);

        $openid=Input::get('s_openid');
        $exist=DB::table('staff')->where('s_openid',$openid)->first();
        if($exist){
            echo "<script>alert('该员工已经存在');window.location.href=$this->url;</script>";
            exit;
        }
       /* header("Content-Type:text/html;charset=utf-8");
        echo $name;
        die;*/

        $this->validate_re($request);

        //die;
        //插入数据
        $res=Staff::create($request->all());
        //dd($res);
        if($res){
            echo "<script>alert('添加成功');window.location.href=$this->url;</script>";
        }else{
            echo "<script>alert('添加失败');window.history.back(-1);</script>";
        }
    }


    public function update($openid){

        $staff=DB::table('staff')->where('s_openid',$openid)->first();
        //var_dump($staff);
        return view('Staff/update',[
            'staff'=>$staff,
        ]);
    }

    public function save(Request $request){
        $input=Input::except('_token');
        //var_dump($input);

        $this->validate_re($request);

        $openid=$input['s_openid'];
        $res=DB::table('staff')->where('s_openid',$openid)->update($input);
        if($res){
            echo "<script>alert('更新成功');window.location.href=$this->url;</script>";
        }else{
            echo "<script>alert('更新失败');window.history.back(-1);</script>";
        }
        //die;
    }


    //重复调用的验证
    function validate_re($request){
        $rules = [
            's_name'=>'required',
            's_department'=>'required',
        ];

        $messages = [
            's_name.required' => '请填写成员名称',
            's_department.required' => '请填写所属部门',
        ];

        $this->validate($request, $rules,$messages);
    }
}
