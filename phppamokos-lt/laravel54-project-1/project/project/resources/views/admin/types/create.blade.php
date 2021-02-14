@extends('base')

@section('content')
<h2>Naujas tipas</h2>

@if($errors->has())
  @foreach ($errors->all() as $error)
    {{ $error }}<br />
  @endforeach
  <br />
@endif

{!! Form::open(array('url' => 'admin/aiksteliu_tipai')) !!}
	Pavadinimas:
	<br />
	{!! Form::text('title', old('title')) !!}
	<br />
	{!! Form::submit('Saugoti') !!}
{!! Form::close() !!}

@stop