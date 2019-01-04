<?php
/**
 * Created by PhpStorm.
 * User: mulaffer
 * Date: 11/24/16
 * Time: 3:13 PM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;

class NewAuthenticate
{
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        //dd($guards);
        $user=$this->authenticate($guards);

        //dd($user);

        if(!$request->ajax() && $user->status!='A'){


            //dd(explode("_",Auth::getName())[1]);

            if(!empty($guards)){

                $this->auth->guard($guards[0])->logout();
                $request->session()->flush();
                $request->session()->regenerate();
                return redirect('/studentlogin');

            }

            $this->auth->guard()->logout();
            $request->session()->flush();
            $request->session()->regenerate();
            return redirect('/login');


        }

        if($request->ajax() && $request->wantsJson() && $user->status!='A'){

            $request->session()->flush();
            $request->session()->regenerate();


            return response()->json(['status' => 99]);

        }



        return $next($request);
    }

    /**
     * Determine if the user is logged in to any of the given guards.
     *
     * @param  array  $guards
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function authenticate(array $guards)
    {
        if (empty($guards)) {
            return $this->auth->authenticate();
        }

        foreach ($guards as $guard) {
            //dd($this->auth->guard($guard)->check());
            if ($this->auth->guard($guard)->check()) {
                //dd($this->auth->shouldUse($guard));
                $this->auth->shouldUse($guard);
                return $this->auth->user();
            }
        }

        throw new AuthenticationException('Unauthenticated.', $guards);
    }

}