<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改员工</title>
</head>
<body>
	<div><h1>修改员工</h1></div>
	<div><a href="{{url('/Staff/index')}}">返回员工列表</a></div>
	{!!Form::open(['url'=>'Staff/save'])!!}
	<table>
		<tr>{!!Form::hidden('s_openid',$staff->s_openid)!!}</tr>
		<tr>
			<td>{!!Form::label('s_name','员工姓名:')!!}</td>
			<td>{!!Form::text('s_name',$staff->s_name)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('s_department','部门:')!!}</td>
			<td>{!!Form::text('s_department',$staff->s_department)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::submit('修改员工')!!}</td>
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