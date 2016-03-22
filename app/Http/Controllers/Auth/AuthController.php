<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;

use Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Controller\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    //protected $redirectTo = '/';
    //protected $redirectPath = '/dashboard';
    //protected $loginPath = '/auth/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('auth', ['except' => ['getLogin','postLogin']]);
        $this->middleware('is_admin', ['only' => ['getRegister','postRegister']]);    
    }

    /**
     * Muestra el formulario para login.
     */
    public function getLogin(){
        // Verificamos que el usuario no esté autenticado
        if (\Auth::check())
        {
            // Si está autenticado lo mandamos a la raíz donde estara el mensaje de bienvenida.
            return \Redirect::to('/users');
        }
        // Mostramos la vista login.blade.php (Recordemos que .blade.php se omite.)
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        //$field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        //$request->merge([$field => $request->input('login')]);
        $this->validate($request,[
            'email'=>'required|email|max:255',
            'password'=>'required|min:3'
            ]);

        $user_data = array(
           //$field => $request->input('login'),
           'email' => $request->input('email'),
           'password' => $request->input('password'),
           'social' => 0,
           'active' => true
        );
        
        if (\Auth::attempt($user_data,$request->has('remember')))
        {           
            return \Redirect::to('users');
        }

        return redirect('auth/login')
        ->withInput($request->only('email'))
        ->withErrors([
                'email'=>'These credentials do not match our recordssss.'
            ]);     
    }

    public function getRegister(){
        $roles=Role::all();
        return view('auth.register',compact('roles'))->with('message','');;
    }

    public function postLogin2(Request $request){
        
        /*$rules = array(
           '$auth_by' => 'required|email|max:255|unique:users',
           'password' => 'required|confirmed|min:6', 
        );*/

        $auth_by = (str_contains($request->login, '@')) ? 'email' : 'username';

        $validator = $this->auth->attempt([
            $auth_by => $request->login,
            'password' => $request->password,
        ], $request->has('remember'));
        return 1;
        // run the validation rules on the inputs from the form
        //$validator = Validator::make($request->all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return \Redirect::to('auth/login')
                ->withErrors($validator) // send back all errors to the login form
                ->withInput($request->only('email')); // send back the input (not the password) so that we can repopulate the form
        } else {

            // create our user data for the authentication
            $userdata = array(
                'email'     => $request::get('email'),
                'password'  => $request::get('password')
            );

            // attempt to do the login
            if (\Auth::attempt($userdata)) {

                // validation successful!
                // redirect them to the secure section or whatever
                // return Redirect::to('secure');
                // for now we'll just echo success (even though echoing in a controller is bad)
                echo 'SUCCESS!';

            } else {        

                // validation not successful, send back to form 
                return \Redirect::to('auth/login');

            }

        }

        $this->validate($request, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',            
        ]);
        echo 11;
    }

    public function postRegister(Request $request){
        $this->validate($request,[
            'name' => 'required|min:4|max:255|unique:users',
            'email'=>'required|email|max:255|unique:users',
            'password'=>'required|confirmed|min:3'
            ]);

        $user_data = array(
           //$field => $request->input('login'),
           'name'=> $request->input('name'),
           'email' => $request->input('email'),
           'password' => $request->input('password'),
           'role' => $request->input('role')
        );

        $user=User::create([
                'name'=>$user_data['name'],
                'email'=>$user_data['email'],
                'password'=>bcrypt($user_data['password']),
                'active'=>1                
            ]);        
        
        $role=Role::where('id',$user_data['role'])->first();
        
        $user->attachRole($role);       

        return redirect('auth/register')->with('status','Usuario registrado');
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate()
    {
        if (\Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
    }

    /**
     * Muestra el formulario de login mostrando un mensaje de que cerró sesión.
     */
    public function getLogout()
    {
        if(\Auth::check()){
            \Auth::logout();
        }
        return \Redirect::to('auth/login')
                    ->with('message', 'Tu sesión ha sido cerrada.');
    }


    public function getSocialRedirect( $provider )
    {   echo 'prov: '.$provider;
        return Socialite::with($provider)->redirect();
        $providerKey = \Config::get($provider);
        if(empty($providerKey))            
            return view('pages.status')
                ->with('error','No such provider');

        return Socialite::driver( $provider )->redirect();
    }

    public function getSocialHandle( $provider )
    {

        $user = Socialite::driver( $provider )->user();

        $socialUser = null;

        //Check is this email present
        $userCheck = User::where('email', '=', $user->email)->first();

        if(!empty($userCheck))
        {
            $socialUser = $userCheck;
        }
        else
        {
            $sameSocialId = Social::where('social_id', '=', $user->id)->where('provider', '=', $provider )->first();

            if(empty($sameSocialId))
            {
                //There is no combination of this social id and provider, so create new one
                $newSocialUser = new User;
                $newSocialUser->email              = $user->email;
                $name = explode(' ', $user->name);
                $newSocialUser->first_name         = $name[0];
                $newSocialUser->last_name          = $name[1];
                $newSocialUser->save();

                $socialData = new Social;
                $socialData->social_id = $user->id;
                $socialData->provider= $provider;
                $newSocialUser->social()->save($socialData);

                // Add role
                $role = Role::whereName('user')->first();
                $newSocialUser->assignRole($role);

                $socialUser = $newSocialUser;
            }
            else
            {
                //Load this existing social user
                $socialUser = $sameSocialId->user;
            }

        }
        
        if (\Auth::login($socialUser)){
            return \Redirect::to('users');    
        }

        //$this->auth->login($socialUser, true);

        
/*
        if( $this->auth->user()->hasRole('user'))
        {
            return redirect()->route('user.home');
        }

        if( $this->auth->user()->hasRole('administrator'))
        {
            return redirect()->route('admin.home');
        }
*/
        return \App::abort(500);
    }

}
