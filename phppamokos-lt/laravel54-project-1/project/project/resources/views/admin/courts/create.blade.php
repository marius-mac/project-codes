@extends('base')

@section('content')
<h2>Nauja aikštelė</h2>

@if($errors->has())
  @foreach ($errors->all() as $error)
    {{ $error }}<br />
  @endforeach
  <br />
@endif

{!! Form::open(array('url' => 'admin/aiksteles')) !!}
	Pavadinimas:
	<br />
	{!! Form::text('title', old('title')) !!}
	<br /><br />
	Adresas:
	<br />
	{!! Form::text('address', old('address')) !!}
	<br /><br />
	Aprašymas:
	<br />
	{!! Form::textarea('description', old('description')) !!}
	<br /><br />
	Tipas:
	<br />
	{!! Form::select('type_id', $types, old('type_id')) !!}
	<br /><br />
	Miestas:
	<br />
	{!! Form::select('city_id', $cities, old('city_id')) !!}
	<br /><br />
	{!! Form::submit('Saugoti') !!}
</form>
@stop