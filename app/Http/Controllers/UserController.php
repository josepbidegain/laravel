<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Role;

use Session;
use Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

//use Illuminate\Support\Facades\Paginator;
use Illuminate\Pagination\Paginator;
//use Paginator;

use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
      
   public function __construct() {
      //$this->autorizado = (Auth::check() and Auth::user()->getRole(Auth::user()->id) == 1);      
        //$this->middleware('auth');        
        //$this->middleware('is_admin', ['except' => ['show','edit']]);        

/*
        $this->beforeFilter('ver_usuarios', array('only' => 'index') );
        $this->beforeFilter('crear_usuarios', array('only' => 'create') );
        $this->beforeFilter('crear_usuarios', array('only' => 'store') );
        $this->beforeFilter('editar_usuarios', array('only' => 'edit') );
        $this->beforeFilter('editar_usuarios', array('only' => 'update') );
        $this->beforeFilter('eliminar_usuarios', array('only' => 'delete') );
        */
   } 
   
    public function index(Request $request){

        if (\Request::ajax()) {
            $users = User::paginate($request['count']);
            return view('user.ajax-users',compact('users'));
        }

        $users = User::paginate(5);        
        //return view('user.index',['users'=>$users,'user'=>$user]);        
        return view('user.index',compact('users'));        
    }

    public function filter(Request $request,$count){
        echo $count;
        $page = isset($request['page']) ? $request['page'] : 1;
        echo "page: ".$page;
        if ( $page != 1 ){echo "entraaa";
            $users = Paginator(User::all(), $count, $page);
        }else{echo "no entraaa";
            $users = User::paginate($count);
        }        
        
        if (\Request::ajax()){
         return view('user.ajax-users',compact('users'));   
        }
        $users = User::paginate(3);
        return view('user.index',compact('users'));        
    }

    public function search($value){
        //$users = User::all();
        //$searchUsers = Array();
        if (\Request::ajax()) {
            $users=User::where('name', 'LIKE', '%'.$value.'%')->get();            
            /*
            foreach ($users as $user){
                if (Str::contains(Str::lover($user->name),Str::lover($value) )){
                    $searchUsers[]=$user;
                }
            }*/
            return view('user.ajax-search',compact('users'));      
        }
    }

    public function create(){
        $roles=Role::all();
        return view('auth.register',compact('roles'))->with('message','');
    }

    public function store(Request $request)
    {
    }

    public function show($id){
                
        $user=User::find($id);
        return view('user.show',['user'=>$user]);
    }

    public function edit($id){
        $user = User::find($id);
        return view('user.edit',compact('user'));
    }

    public function update(Request $request,$id){
        
        $user = User::find($id);
        $password = $user->password;
        $user->fill($request->all());
        if (empty($request->password)){
            $user->password = $password;
        }else{
            $user->setPasswordAtributte($request->password);
        }

        $user->save();
        
        return Redirect::to("users/$id/edit")->with('status','Usuario editado correctamente');
    }

    public function destroy($id){

        //Si quiero eliminar registro
        /*
        User::destroy($id);        
        Session::flash('message','Usuario eliminado correctamente');
        return Redirect::to('users');
        */

        //si quiero solo desactivar
        $user = User::find($id);
        $user->active = 0;
        $user->save();
        Session::flash('message','Usuario desactivado correctamente');
        return Redirect::to('users');
    }

}
