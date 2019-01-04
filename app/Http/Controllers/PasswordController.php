<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\ActivityRepository\NormalActivity;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function change(Request $request)
    {

        return view('changepassword.change');
    }

    public function update(Request $request,NormalActivity $normalActivity)
    {
        $this->validate($request,[
            'oldpassword' => 'required|min:6',
            'newpassword' => 'required|min:6|confirmed'
        ]);

        if (!Hash::check( $request->get('oldpassword'), User::find(Auth::user()->id)->password)) {

            $msgAndStatus = [
                "error" => 'Wrong OldPassword'
            ];


            return  back()->with($msgAndStatus)->withInput();
        }

        $user = User::find(Auth::user()->id);
        $user->password=bcrypt($request->get('newpassword'));

        if($user->isDirty()){

            try{
                $user->save();

            }catch(\Illuminate\Database\QueryException $e){

                $error_code = $e->errorInfo[1];
                if ($error_code) {

                    $msgAndStatus = [
                        "error" => $e->errorInfo[2]
                    ];

                }
                return  back()->with($msgAndStatus)->withInput();
            }

        }else{

            $msgAndStatus = [
                "error" => 'Your Previous Password Also Same'
            ];

            return  back()->with($msgAndStatus)->withInput();

        }

        $array = [
            "subject_id" =>$user->id,
            "subject_type" =>"App\\User",
            "name" =>"updated_user",
            "key_name" =>$user->email,
            "auth_id" => Auth::user()->id,
            "auth_type" => Auth::getProvider()->getModel()
        ];

        $normalActivity->createActivity($array);

        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');

    }
}
