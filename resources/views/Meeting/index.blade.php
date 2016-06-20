<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>列表页</title>
</head>
<body>
	<div class=""><h1>会议列表</h1></div>
	<div><a href="{{url('/Staff/index')}}"><input type="button" value="员工列表" /></a></div>
	<div><a href="{{url('/Meeting/add')}}"><input type="button" value="添加会议" /></a></div>
@foreach($meeting_arr as $k=>$v)
	<div>{{$v->m_type}} -- {{$v->m_subject}}</div>
	{!!Form::open(['method'=>'POST','action'=>['MeetingController@delete']])!!}
	@if($v->m_state == 1)
	<div>待召开</div>
	<div><a href="{{url('/Meeting/update',[$v->m_id])}}"><input type="button" value="修改会议" /></a></div>
	<div>
		<input type="hidden" name="mid" value="{{$v->m_id}}"/>
		<input type="submit" value="取消会议" onclick="javascript:return del()"/>
	</div>
	@else
	<div>已召开</div>
	<div>
		<input type="hidden" name="mid" value="{{$v->m_id}}"/>
		<input type="submit" value="删除会议" onclick="javascript:return del()"/>
	</div>
	@endif
	{!!Form::close()!!}
	<div>
		<ul>
			@foreach($v->member as $kk=>$vv)
			<li>{{$vv->s_openid}}</li>
			<li>{{$vv->s_name}}</li>
			@endforeach
		</ul>
	</div>
	<hr />
@endforeach
<script type="text/javascript">
	
	function del(){
	var msg = "您真的确定要删除吗？请确认！"; 
	  if (confirm(msg)==true){ 
	    return true; 
	  }else{ 
	    return false; 
	  } 
	}
</script>
</body>
</html>