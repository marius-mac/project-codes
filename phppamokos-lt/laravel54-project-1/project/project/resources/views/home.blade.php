@extends('base')

@section('content')
<h1>Naujausios aikštelės</h1>
@foreach ($newest_courts as $court)
<a href="{{ url('aikstele/' . $court->id) }}"><h4>{{ $court->title }}</h4></a>
{{ $court->address }}, {{ $court->city->title }}
@endforeach

<h2>Aikštelės paieška</h2>
<form action="{{ url('aiksteles') }}" method="post">
  <input type="text" name="search" />
  <input type="submit" name="search_submit" value=" Ieškoti " />
</form>
@stop