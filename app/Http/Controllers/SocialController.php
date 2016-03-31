<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Social;
use App\Role;

use Auth;
use Socialite;

class SocialController extends Controller
{
	public function __construct(){
		$this->middleware('guest');
	}

	public function getSocialAuth($provider=null){
		if (!config("services.".$provider)) abort(404);

		return Socialite::driver($provider)->redirect();		
	}

	
	public function getSocialAuthCallback(Request $request,$provider=null)
	{
		//dd(Socialite::driver($provider)->user());

        $state = $request->get('state');
        $request->session()->put('state',$state);

        if(\Auth::check()==false){
          session()->regenerate();
        }

		if ($user_provider = Socialite::driver($provider)->user())
		{
	        //Check is this email present
	        $userCheck = User::where('email', '=', $user_provider->email)->first();

	        if(!empty($userCheck))
	        {
	            $user = $userCheck;
	            /* preguntar si quiere asociar cuenta a usuario
	            	ver si siempre ingresa aca login/registro, pq hay que preguntar
	            	1 sola vez
	            */
	        }
	        else
	        {	//busco id de proveedor si ya esta creado
	        	$sameSocialId = Social::where('uid_provider', '=', $user_provider->id)->where('provider', '=', $provider )->first();

	        	if(empty($sameSocialId))
            	{
            		$user = new User();
					$user->name = $user_provider->name;
					$user->email = $user_provider->email;
					$user->avatar = $user_provider->avatar;
					$user->active = 1;
					$user->social = 1;
					$user->save();

					//Registrar Información extra
					$social = new Social;
					$social->user_id = $user->id;
					$social->provider = $provider;
					$social->uid_provider = $user_provider->id;
					$social->save();

					//$user->social()->save($social);

	                // Add role
	                $role = Role::whereName('user')->first();
	                $user->attachRole($role);       

            	}else
            		{
	            		//Load this existing social user
	                	$user = User::find($sameSocialId->user_id);
            		}

			}
			
			\Auth::login($user);

			return redirect('users');

		}else
			{
				return 'Error';
			}
	
	}
}
