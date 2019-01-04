<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use App\ActivityRepository\NormalActivity;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use NewRegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'phonenumber' => 'required|digits_between:9,10',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data,NormalActivity $normalActivity)
    {
        //dd($data['faculty']);
        $user=User::create([
            'name' => $data['name'],
            'phone_number' => $data['phonenumber'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_token' => str_random(60),
            'status' => $data['status'],
        ]);


        $array = [
            "subject_id" =>$user->id,
            "subject_type" =>"App\\User",
            "name" =>"created_user",
            "key_name" =>$data['email'],
            "auth_id" => Auth::user()->id,
            "auth_type" => Auth::getProvider()->getModel()
        ];

        $normalActivity->createActivity($array);

        $this->assignRoles($user,$data['role']);

        return $user;
    }


    protected function assignRoles($user,$roleIds){

            $user->roles()->attach($roleIds);

    }
}
