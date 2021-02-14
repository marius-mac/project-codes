@extends('base')

@section('content')
<h2>Naujas miestas</h2>

@if($errors->has())
  @foreach ($errors->all() as $error)
    {{ $error }}<br />
  @endforeach
  <br />
@endif

{!! Form::open(array('url' => 'admin/miestai')) !!}
	Pavadinimas:
	<br />
	{!! Form::text('title', old('title')) !!}
	<br />
	{!! Form::submit('Saugoti') !!}
{!! Form::close() !!}

@stop