@extends('base')

@section('content')
<h2>Aikštelių tipai</h2>

<table class="data-table">
<tr>
	<th>Tipas</th>
	<th>Veiksmai</th>
</tr>
@if ($types->count() > 0)
	@foreach ($types as $type)
	<tr>
		<td>{{ $type->title }}</td>
		<td>
			<a href="{{ url('admin/aiksteliu_tipai/' . $type->id . '/edit') }}">Redaguoti</a>
			<form style="display:inline" 
				action="{{ url('admin/aiksteliu_tipai/' . $type->id) }}" method="post" 
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
<a href="{{ url('admin/aiksteliu_tipai/create') }}">Naujas tipas</a>
@stop