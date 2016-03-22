@extends('layouts.app')

@section('content')

<div class="container">	

  <h2>Admin Roles</h2>
  
  <table class="table">
	@if (session('status'))
	    <div class="alert alert-success">
	        {{ session('status') }}
	    </div>
	@endif
  <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <a href="/roles/create" class="btn btn-success fa fa-btn fa-user">Create</a></div>
    </div>
	<thead>
		<th>Nombre</th>
		<th>Display Name</th>
		<th>Description</th>
		<th>Operaciones</th>
	</thead>
		@foreach ($roles as $role)
			<tbody>
			<tr>
				<td>{{$role->name}}</td>
				<td>{{$role->display_name}}</td>
				<td>{{$role->description}}</td>
				<td>
					<a class="btn btn-primary" href="/roles/{{ $role->id }}/edit">Editar</a>
				</td>
				<td>
					<form action="/roles/{{ $role->id }}" method="POST">
						<input type="hidden" value="{{ csrf_token() }}" name="_token" />
						<input type="hidden" value="DELETE" name="_method" />
						<input class="btn btn-danger" type="submit" value="Eliminar" />
					</form>					
				</td>
				</tr>
			</tbody>
		@endforeach
	</table>
</div>
@endsection