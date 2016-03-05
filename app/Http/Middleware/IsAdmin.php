<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;

use Closure;
use Illuminate\Support\Facades\Auth;


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
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest() || $this->auth->user()->type != 'admin') {
            return redirect()->to('auth/login');
        }elseif ($request->ajax()) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}