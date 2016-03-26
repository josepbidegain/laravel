@extends('layouts.app')

@section('content')

<div class="container">	
<div class="panel panel-default">
  	<div class="panel-heading">
        <h2>My Users
            <a href="/users/create" class="btn btn-primary pull-right">Create new user</a>
        </h2>
  	</div>
  </div>

  	<div class="panel-body">
	
		<div id="message"></div>

  	  	<div class="row">
	  	<div class="col-xs-6">
	  	<div id="DataTables_Table_0_length" class="dataTables_length">
	  		<label>Show 
		  		<select name="count_users" id="count_users">
			  		<option value="5">5</option>
			  		<option value="10">10</option>
			  		<option value="50">50</option>
			  		<option value="100">100</option>
		  		</select> 
	  		entries</label>
	  	</div>
  	   	</div>
	  	<div class="col-xs-6">
		  	<div class="dataTables_filter" id="DataTables_Table_0_filter">
		  		<label>Search:
		  			<input aria-controls="DataTables_Table_0" placeholder="" class="form-control input-sm" type="search">
		  		</label>
		  	</div>
	  	</div>
  	</div>
	<div id="users-ajax">

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

	</table>
			 {!! $users->render() !!}
	</div>

	<form action="/export/" method="get">
	<select name="formato">
	<option value="excel">Excel</option>
	<option value="pdf">PDF</option>
	<option value="csv">CSV</option>
	</select>
	<input type="submit" value="Exportar" />
	</form>
	

	
</div>
@endsection

 <script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
    <script>
     
        // Ajax pagination
 
        $(function() {
            $('body').on('click', '.pagination li a', function (e) {
                getUsers($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });

            $('#count_users').change(function(e){            	
            	//getUsersPerPage($(this).val());            	
            	getUsersPerPage($(this).val());
            });
            //$('body').on('change','#count_users',function(e){alert( $(this).value();
            	//getUsersPerPage($(this).value());            	
            //});
        });
 
        function getUsers(page) {
            $.ajax({
                url : '?page=' + page,
                dataType: 'text',
            }).done(function (data) {console.log(data);
                $('#users-ajax').html(data);
            }).fail(function (error) {console.log(error);
                alert('Users could not be loaded.');
            });
        }

        function getUsersPerPage(count){
        	$.ajax({
                url : 'filterusers/' + count,
                dataType: 'text',
            }).done(function (data) {console.log(data);
                $('#users-ajax').html(data);
            }).fail(function (error) {console.log(error);
                //alert('Users could not be loaded.');
            });
        }
    </script>