<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        //dd($request->user());

        // Auth::guard($guard) returns a guard instance(SessionGuard) on this check method determine  if the current user is authenticated.
        //if the user authenticated we will show the homepage (dashboard)

        switch ($guard){
            case 'student':
                if (Auth::guard($guard)->check()) {
                    return redirect('studenthome');
                }
                break;

            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('home');
                }
                break;
        }

        //if the user un authenticated we are passing the request to next layer thet means we are going to show the login page
        //dd($next($request));
        return $next($request);
    }
}
