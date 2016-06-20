<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>员工列表</title>
</head>
<body>
	<div class=""><h1>员工列表</h1></div>
	<div><a href="{{url('/Meeting/index')}}"><input type="button" value="会议列表" /></a></div>
	<div><a href="{{url('/Staff/add')}}"><input type="button" value="添加员工" /></a></div>
	<hr />
@foreach($staff_arr as $k=>$v)
	<div><a href="{{url('/Staff/update',[$v->s_openid])}}"><input type="button" value="修改信息" /></a></div>
	<div>姓名:{{$v->s_name}}</div>
	<div>部门:{{$v->s_department}}</div>
	<hr/>
@endforeach

</body>
</html>