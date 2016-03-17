<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Permission;
use App\Role;
use App\User;

use Session;

use Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;


class RoleController extends Controller {

	
    public function __construct()
    {
    	$this->middleware('auth');        
        $this->middleware('is_admin');        
    	/*
        $this->beforeFilter('ver_roles', array('only' => 'index') );
        $this->beforeFilter('crear_roles', array('only' => 'create') );
        $this->beforeFilter('crear_roles', array('only' => 'store') );
        $this->beforeFilter('editar_roles', array('only' => 'edit') );
        $this->beforeFilter('editar_roles', array('only' => 'update') );
        $this->beforeFilter('eliminar_roles', array('only' => 'delete') );
        */
    }
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('role.index', array('roles' => Role::all(), 'permisos' => Permission::all() ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('role.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
 		$this->validate($request,[
            'name' => 'required|min:4|max:255|unique:roles',
            'display_name'=>'required|min:4|max:255|unique:roles',
            'description'=>'required|min:3'
            ]);

        $user_data = array(           
           'name'=> $request->input('name'),
           'display_name' => $request->input('display_name'),
           'description' => $request->input('description')           
        );

        Role::create([
                'name'=>$user_data['name'],
                'display_name'=>$user_data['display_name'],
                'description'=>$user_data['description'],
                'active'=>1                
            ]);		
        $roles = Rolle::all();
        return view('roles.index',compact('roles'))->with('status','Role creado correctamente');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$role=Role::find($id);
		return view('role.edit', compact('role'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request,$id)
	{
		$role = Role::find($id);
        $role->name = Input::get('name');
        $role->save();
        return Redirect::route('roles.index');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$role=Role::find($id);
		$role->active = 0;
        $role->save();
        Session::flash('status','Role desactivado correctamente');
        
        $roles=Role::all();
        return view('role.index',compact('roles'));
	}


}