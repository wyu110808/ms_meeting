<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>签到</title>
</head>
<body>
	<div>
		<ul>
			<li><span>{{$meeting->m_date1}}</span>----<span>{{$meeting->m_date2}}</span></li>
			<li>{{$meeting->m_subject}}:{{$meeting->m_type}}</li>
			<li>{{$meeting->m_author}}</li>
		</ul>
	</div>
	<div>
		<img src="" alt="" />
		<p>{{$member->s_name}}</p>
	</div>
	{!!Form::open(['action'=>'SignController@check','method'=>'post'])!!}
	<input type="hidden" name="m_id" value="{{$mid}}"/>
	<input type="hidden" name="s_openid" value="{{$openid}}"/>
	<input type="hidden" name="r_date" value="{{time()}}"/>
	{!!Form::submit('签到')!!}
	{!!Form::close()!!}
</body>
</html>