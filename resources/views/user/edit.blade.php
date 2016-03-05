@extends('app')

@section('content')
{!!Form::model($user,['route'=>['users.update',$user->id],'method'=>'PUT'])!!}

@include('user.forms.user')

{!!Form::submit('Editar',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}

{!!Form::open(['route'=>['users.destroy',$user->id],'method'=>'DELETE'])!!}
	{!!Form::submit('Eliminar',['class'=>'btn btn-danger'])!!}
{!!Form::close()!!}

{!!Form::open(['route'=>['users.index',$user->id],'method'=>'GET'])!!}
		{!!Form::submit('Volver',['class'=>'btn btn-info'])!!}
	{!!Form::close()!!}
@endsection