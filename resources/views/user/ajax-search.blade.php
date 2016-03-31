@foreach ($users as $u)
	<br><a href="/users/{{ $u->id }}/edit">{{$u->name}}</a><br>
@endforeach