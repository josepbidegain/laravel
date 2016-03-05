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

class UserController extends Controller
{
   
   private $autorizado;
   
   public function __construct() {
      //$this->autorizado = (Auth::check() and Auth::user()->getRole(Auth::user()->id) == 1);      
        $this->middleware('auth');        
        $this->middleware('is_admin', ['except' => ['index','show','edit']]);        

/*
        $this->beforeFilter('ver_usuarios', array('only' => 'index') );
        $this->beforeFilter('crear_usuarios', array('only' => 'create') );
        $this->beforeFilter('crear_usuarios', array('only' => 'store') );
        $this->beforeFilter('editar_usuarios', array('only' => 'edit') );
        $this->beforeFilter('editar_usuarios', array('only' => 'update') );
        $this->beforeFilter('eliminar_usuarios', array('only' => 'delete') );
        */
   } 

    public function index(){

        //if(!$this->autorizado) return ('nada');
        
        $user = Auth::user();
        $users = User::paginate(3);
        
        
        //return view('user.index',['users'=>$users,'user'=>$user]);        
        return view('user.index',['users'=>$users]);        
    }
/*
    public function index($array){
        var_dump($array);
        return;
        //si se ha iniciado sesión no dejamos volver
auth if(Auth::check(in
        {
             $users = User::paginate(3);
        //$users = User::where('active',1); NO FUNCIONA, REVISAR
        //return view('user.index',compact('users'));
            return view('user.index',['users'=>$users]);           
        }else{            
            return Redirect::to('auth/login')->with('message','Debes estar logueado');           
        }

        
    }
    */

    public function create(){
        return view('user.create');
    }

    public function store(Request $request){
    	
        User::create([
    			'name'=>$request['name'],
    			'email'=>$request['email'],
    			'password'=>$request['password'],
                'active'=>1,
    		]);


    	return redirect('user')->with('message','store');
    }

    public function show($id){
                
        $user=User::find($id);
        return view('user.show',['user'=>$user]);
    }

    public function edit($id){
        $user = User::find($id);
        return view('user.edit',['user'=>$user]);
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
        Session::flash('message','Usuario editado correctamente');
        return Redirect::to('users');
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
