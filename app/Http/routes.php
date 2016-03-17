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


Route::get('','HomeController@index');




Route::group(['middleware' => ['web'],'role'=>'admin'], function () {

	$s = 'social.';
	Route::get('social/{provider?}', ['as' => $s . 'redirect',   'uses' => 'SocialController@getSocialAuth']);

	Route::get('social/callback/{provider?}', ['as' => $s . 'handle',     'uses' => 'SocialController@getSocialAuthCallback']);

	
	Route::resource('users','UserController');	 
	Route::resource('roles','RoleController');

	//Route::auth();
	Route::controllers([
		'auth'=>'Auth\AuthController',
		'password'=>'Auth\PasswordController',
	]);
/*
	Route::get('sendemail', function () {

	    $data = array(
	        'name' => "Learning Laravel",
	    );

	    Mail::send('auth.login', $data, function ($message) {
	        $message->from('josepbidegain@gmail.com', 'Learning Laravel');
	        $message->to('jpbidegain@live.com')->subject('Learning Laravel test email');
	    });

	    return "Your email has been sent successfully";
	});
	*/
	
});

Route::any( '(.*)', 'NotFoundController@index');