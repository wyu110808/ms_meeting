@extends('common/main')
@section('content')
		<h1>About me</h1>
		<p>个人简介</p>
		
		<p>{{$first}},{{$second}}</p>
		<p>{{$boy}}</p>
		<p>{{$girl}}</p>

	@foreach($data_arr as $k=>$v)
		
		<li>id:{{$v['id']}}</li>
		<li>name:{{$v['name']}}</li>
		<li>sex:{{$v['sex']}}</li>
		
	@endforeach
	<hr/>
	@foreach($db_res as $v)
		<li>id:{{$v->id}}</li>
		<li>name:{{$v->name}}</li>
		<li>sex:{{$v->sex}}</li>
	@endforeach

	<a href="/about">test_url1</a>
	<a href="{{action('PagesController@about')}}">test_url2</a>
	<a href="{{url('/contact')}}">test_url3</a>
	<hr>
	
@stop