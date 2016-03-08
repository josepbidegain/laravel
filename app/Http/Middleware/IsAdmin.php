<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;


class IsAdmin
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        $user = $this->auth->user();        
        $route = $request->route();
        $actions = $route->getAction();
        if(array_key_exists('role',$actions)) {
            $role=$actions['role'];
            if(!$user->hasRole($role)) {
                return redirect("users/$user->id");                
                //return response('Unauthorized Access');                
            }
        }

        return $next($request);
    }

}