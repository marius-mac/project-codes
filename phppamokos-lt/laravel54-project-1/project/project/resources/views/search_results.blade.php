@extends('base')

@section('content')

@if ($courts->count())
  @foreach ($courts as $court)
    <a href="{{ url('aikstele/' . $court->id) }}"><h4>{{ $court->title }}</h4></a>
    {{ $court->address }}, {{ $court->city->title }}
  @endforeach
@else
  Nerasta aikštelių.
@endif

@stop