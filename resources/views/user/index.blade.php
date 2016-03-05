@extends('app')

@section('content')
<ul class="nav nav-pills nav-stacked">
  <li>Users</li>
  <li>Productos</li>
  <li>Categorias</li>
  <li>Producto/Categorias</li>
  <li>Logout</li>
</ul>
<div class="container">

	<h1> Bienvenido</h1>    
    <p> {{ link_to('/auth/logout', 'Cerrar sesión') }} </p>

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