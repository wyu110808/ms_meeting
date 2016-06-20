<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>修改会议</title>
</head>
<body>

	<div><h1>修改会议</h1></div>
	<div><a href="{{url('/Meeting/index')}}">返回列表</a></div>
	{!!Form::open(['action'=>'MeetingController@save','method'=>'POST'])!!}
	<table>
		<tr>{!!Form::hidden('m_id',$meeting->m_id)!!}</tr>
		<tr>
			<td>{!!Form::label('m_subject','会议主题:')!!}</td>
			<td>{!!Form::text('m_subject',$meeting->m_subject)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('m_type','会议类别:')!!}</td>
			<td>{!!Form::text('m_type',$meeting->m_type)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('m_address','会议地点:')!!}</td>
			<td>{!!Form::text('m_address',$meeting->m_address)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('m_member','会议对象:')!!}</td>
			<td>{!!Form::text('m_member',$meeting->m_member)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('m_department','会议部门:')!!}</td>
			<td>{!!Form::text('m_department',$meeting->m_department)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('m_date1','开始时间:')!!}</td>
			<td>{!!Form::input('date','m_date1',date('Y-m-d'))!!}</td>
			
		</tr>
		<tr>
			<td>{!!Form::label('m_date2','结束时间:')!!}</td>
			<td>{!!Form::input('date','m_date2',date('Y-m-d'))!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('m_mc','主持人:')!!}</td>
			<td>{!!Form::text('m_mc',$meeting->m_mc)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('m_author','主讲人:')!!}</td>
			<td>{!!Form::text('m_author',$meeting->m_author)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::label('m_comment','备注:')!!}</td>
			<td>{!!Form::textarea('m_comment',$meeting->m_comment)!!}</td>
		</tr>
		<tr>
			<td>{!!Form::submit('预约会议')!!}</td>
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