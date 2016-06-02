@extends('common/main')
@section('content')

{!!Form::open(['url'=>'/articles/add'])!!}
{!!Form::label('title','Title:')!!}
{!!Form::text('title',null,['class'=>'test'])!!}
{!!Form::submit('Add')!!}
{!!Form::close()!!}

@stop