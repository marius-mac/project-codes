@extends('base')

@section('content')
<h2>Miesto redagavimas</h2>

@if($errors->has())
  @foreach ($errors->all() as $error)
    {{ $error }}<br />
  @endforeach
  <br />
@endif

{!! Form::open(array('url' => 'admin/miestai/' . $city->id, 'method' => 'put')) !!}
	Pavadinimas:
	<br />
	{!! Form::text('title', $city->title) !!}
	<br />
	{!! Form::submit('Saugoti') !!}
{!! Form::close() !!}

@stop