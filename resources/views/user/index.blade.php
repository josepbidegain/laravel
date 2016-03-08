@extends('layouts.app')

@section('content')

<div class="container">	

  <h2>Admin usuarios</h2>
  
  <table class="table">

	<thead>
		<th>Nombre</th>
		<th>Email</th>
		<th>Operaciones</th>
	</thead>
		@foreach ($users as $user)
			<tbody>
			<tr>
				<td>{{$user->name}}</td>
				<td>{{$user->email}}</td>
				<td>
					{!!link_to_route('users.edit', $title = 'Editar', $parameters = $user->id, $attributes = ['class'=>'btn btn-primary']);!!}
				</td>
				<td>
					{!!Form::open(['route'=>['users.destroy',$user->id],'method'=>'DELETE'])!!}
						{!!Form::submit('Eliminar',['class'=>'btn btn-danger'])!!}
					{!!Form::close()!!}
				</td>
				</tr>
			</tbody>
		@endforeach
		{!! $users->render() !!}
	</table>
</div>
@endsection