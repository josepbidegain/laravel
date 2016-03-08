@extends('layouts.app')

@section('content')

{!!Form::open(['route'=>'users.store','method'=>'POST'])!!}

@include('user.forms.user')

{!!Form::submit('Crear',['class'=>'btn btn-primary'])!!}
{!!Form::close()!!}
@endsection
