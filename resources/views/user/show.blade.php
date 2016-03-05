@extends('app')

@section('content')
	<div class="form-group">
		<label>Nombre:</label>
		<label>{{ $user->name }}</label>		
	</div>
	<div class="form-group">
		<label>Email:</label>
		<label>{{ $user->email }}</label>		
	</div>
	{!!Form::open(['route'=>['users.index',$user->id],'method'=>'GET'])!!}
		{!!Form::submit('Volver',['class'=>'btn btn-info'])!!}
	{!!Form::close()!!}
	
@endsection