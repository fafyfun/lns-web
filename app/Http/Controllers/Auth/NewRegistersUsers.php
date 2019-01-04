<?php
/**
 * Created by PhpStorm.
 * User: mulaffer
 * Date: 11/23/16
 * Time: 1:02 AM
 */

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\ActivityRepository\NormalActivity;
use App\Role;


trait NewRegistersUsers
{
    use NewRedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "userActive" =>"active",
            "userIn" =>"in",
            "registerUserActive" =>"active"
        ];


        $roles = Role::select('id','name')->get();

        return view('auth.register',compact(['classItems','roles']));
    }



    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request,NormalActivity $normalActivity)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all(),$normalActivity)));

        //$this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
    }
}