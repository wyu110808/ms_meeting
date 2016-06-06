<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>列表页</title>
</head>
<body>
	<div class=""><h1>会议列表</h1></div>
	<div><a href="{{url('/Add/index')}}"><input type="button" value="添加会议" /></a></div>
	<div><a href="{{url('/Update/index')}}"><input type="button" value="修改会议" /></a></div>
@foreach($meeting_arr as $k=>$v)
	<div>{{$v->m_type}} -- {{$v->m_subject}}</div>
	<div><input type="button" value="待召开" /></div>
	<div>
		<ul>
			@foreach($v->member as $kk=>$vv)
			<li>{{$vv->s_openid}}</li>
			<li>{{$vv->s_name}}</li>
			@endforeach
		</ul>
	</div>
@endforeach
</body>
</html>