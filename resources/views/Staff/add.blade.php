<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>添加员工</title>
</head>
<body>
	<div><h1>添加员工</h1></div>
	<div><a href="{{url('/Staff/index')}}">返回员工列表</a></div>
	{!!Form::open(['url'=>'Staff/insert'])!!}
	<table>
		<tr>
			<td>{!!Form::label('s_openid','openid:')!!}</td>
			<td>{!!Form::text('s_openid',null)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('s_name','员工姓名:')!!}</td>
			<td>{!!Form::text('s_name',null)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('s_department','部门:')!!}</td>
			<td>{!!Form::text('s_department',null)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::submit('添加员工')!!}</td>
		</tr>
	</table>
	{!!Form::close()!!}
	@if ($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</body>
</html>