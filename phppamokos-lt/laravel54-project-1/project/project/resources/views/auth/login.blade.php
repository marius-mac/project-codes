@extends('base')

@section('content')

<h2>Prisijungimas</h2>

@if ($errors->has())
  <ul>
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
@endif

{!! Form::open(['url' => 'auth/login']) !!}

    El.pašto adresas
    <br />
    {!! Form::email('email', old('email')) !!}
    <br /><br />
    Slaptažodis
    <br />
    {!! Form::password('password') !!}
    <br /><br />
    <button type="submit">Prisijungti</button>
{!! Form::close() !!}

@stop