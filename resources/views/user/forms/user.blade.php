<div class="form-group">
	{!!Form::label('Nombre:')!!}
	{!!Form::text('name',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
</div>
<div class="form-group">
	{!!Form::label('Email:')!!}
	{!!Form::text('email',null,['class'=>'form-control','placeholder'=>'example admin@admin.com'])!!}
</div>
<div class="form-group">
	{!!Form::label('Password:')!!}
	{!!Form::password('password',['class'=>'form-control'])!!}
</div>