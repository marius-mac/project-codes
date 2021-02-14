@extends('base')

@section('content')
<h2>Aikštelės</h2>

<table class="data-table">
<tr>
	<th>Pavadinimas</th>
	<th>Adresas</th>
	<th>Veiksmai</th>
</tr>
@if ($courts->count() > 0)
	@foreach ($courts as $court)
	<tr>
		<td>{{ $court->title }}</td>
		<td>{{ $court->address }}</td>
		<td>
			<a href="{{ url('admin/aiksteles/' . $court->id . '/edit') }}">Redaguoti</a>
			<form style="display:inline" 
				action="{{ url('admin/aiksteles/' . $court->id) }}" method="post" 
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
	<td colspan="3" class="align-center">Duomenų nėra.</td>
</tr>
@endif
</table>
<br />
<a href="{{ url('admin/aiksteles/create') }}">Nauja aikštelė</a>
@stop