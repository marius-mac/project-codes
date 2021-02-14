@extends('base')

@section('content')

<h1>{{ $court->title }}</h1>
{{ $court->address }}, {{ $court->city->title }}
<br /><br />
<p>{{ $court->description }}</p>

@stop