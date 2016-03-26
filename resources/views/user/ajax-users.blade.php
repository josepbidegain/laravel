<table aria-describedby="DataTables_Table_0_info" role="grid" id="DataTables_Table_0" class="table table-condensed table-stripe ddt-responsive dataTable no-footer dtr-inline collapsed">

	<thead>
		<th>#</th>
		<th>Name</th>
		<th>Email</th>
		<th>Role</th>
		<th>Active</th>
		<th>Last Conection</th>
		<th>Operaciones</th>
	</thead>
		@foreach ($users as $user)
		<tbody>
		<tr class="odd" role="row">
			<td class="sorting_1">{{$user->id}}</td>
			<td>{{$user->name}}</td>
			<td>{{$user->email}}</td>
			<td>{{$user->role}}</td>
			<td>{{$user->active}}</td>
			<td>{{$user->session}}</td>
			<td><a href="/users/{{ $user->id }}/edit" class="btn btn-primary">Edit</a></td>
			<td>
				{!!Form::open(['route'=>['users.destroy',$user->id],'method'=>'DELETE'])!!}
					{!!Form::submit('Deactivate',['class'=>'btn btn-danger'])!!}
				{!!Form::close()!!}
			</td>
			</tr>
		</tbody>
	@endforeach

	</div>

	</table>

	{!! $users->render() !!}
