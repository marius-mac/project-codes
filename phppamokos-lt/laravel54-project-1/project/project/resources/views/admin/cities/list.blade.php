@extends('base')

@section('content')
<h2>Miestai</h2>

<table class="data-table">
<tr>
	<th>Miestas</th>
	<th>Veiksmai</th>
</tr>
@if ($cities->count() > 0)
	@foreach ($cities as $city)
	<tr>
		<td>{{ $city->title }}</td>
		<td>
			<a href="{{ url('admin/miestai/' . $city->id . '/edit') }}">Redaguoti</a>
			<form style="display:inline" 
				action="{{ url('admin/miestai/' . $city->id) }}" method="post" 
				onsubmit="return confirm('Ar tikrai?')">
				<input type="hidden" name="_method" value="DELETE" />
				{{ csrf_field() }}
				<input type="submit" value="Trinti" />
			</form>
		</td>
	</tr>
	@endforeach
@else
<tr>
	<td colspan="2" class="align-center">Duomenų nėra.</td>
</tr>
@endif
</table>
<br />
<a href="{{ url('admin/miestai/create') }}">Naujas miestas</a>
@stop