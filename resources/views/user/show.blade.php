@extends('layouts.app')

@section('content')
	<div class="form-group">		
		<img src="{{ $user->avatar }}">
	</div>

	<div class="form-group">
		<label>Nombre:</label>
		<label>{{ $user->name }}</label>		
	</div>
	<div class="form-group">
		<label>Email:</label>
		<label>{{ $user->email }}</label>		
	</div>
	
@endsection