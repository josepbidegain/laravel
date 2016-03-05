<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


//Route::get('auth/logout', array('uses' => 'Auth\AuthController@doLogout'));

Route::post('alias',['as'=>'probandoAlias','uses'=>'Auth\AuthController@alias']);


Route::get('hola',function(){
	$route = Route::current();

	$name = $route->getName();
	echo $name;
	$actionName = $route->getActionName();
	echo $actionName;
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/


Route::resource('users','UserController');	

Route::group(['middleware' => ['web']], function () {

	Route::controllers([
		'auth'=>'Auth\AuthController',
		'password'=>'Auth\PasswordController',
	]);
	
	/*
		//Rutas privadas solo para usuarios autenticados
		Route::group(['before' => 'auth'], function()
		{
		    Route::get('/', 'HomeController@showWelcome'); // Vista de inicio
		});

	*/
	/*
	// Authentication routes...
	Route::get('auth/login', 'Auth\AuthController@getLogin');
	Route::post('auth/login', ['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
	Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@doLogout']);

	// Registration routes...
	Route::get('auth/register', 'Auth\AuthController@getRegister');
	Route::post('auth/register', ['as' => 'auth/register', 'uses' => 'Auth\AuthController@postRegister']);
	*/
});
