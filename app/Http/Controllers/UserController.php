<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\User;
use App\Role;
use Auth;
use App\ActivityRepository\NormalActivity;

class UserController extends Controller
{
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

     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $collectionId=[];

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "userActive" =>"active",
            "userIn" => "in",
            "manageUserActive" =>"active"
        ];

            //fetch all users records
            $users=User::paginate(10);


            if($users->count() > 0){

                $collectionId=$users->pluck('id');
            }
            //$collectionId=collect($allId);

        return view('users.show',compact(['users','collectionId','classItems']));
    }



    public function loopThroughUsers($users,$allId){

        foreach ($users as $user){

            array_push($allId,$user->id);

        }

        return $allId;
    }

    /**

     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){

        //$user=User::findOrFail($id);


        $roles = Role::select('id','name')->get();

        $user=User::with('roles')->where('id',$id)->get();



        return view('users.edit',compact(['user','roles']));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request,NormalActivity $normalActivity, $id){

        $update = false;

        $this->validate($request, [
            'name' => 'required|max:255',
            'phonenumber' => 'required|digits_between:9,10',
            'email' => 'required|email|max:255',
            'password' => 'min:6|nullable',
            'role' => 'required',
        ]);






        $user = User::find($id);

       // var_dump($user);

        if( !empty($request->get('password'))){

            $user->name=trim($request->get('name'));
            $user->phone_number=trim($request->get('phonenumber'));
            $user->email=trim($request->get('email'));
            $user->status=trim($request->get('status'));
            $user->password=bcrypt($request->get('password'));

        }else{

            $user->name=trim($request->get('name'));
            $user->phone_number=trim($request->get('phonenumber'));
            $user->email=trim($request->get('email'));
            $user->status=trim($request->get('status'));


        }





        if($user->isDirty()){

            $update = true;

            try{
                $user->save();

            }catch (\Illuminate\Database\QueryException $e){

                $error_code = $e->errorInfo[1];
                if ($error_code) {

                    $msgAndStatus = [
                        "error" => $e->errorInfo[2]
                    ];
                }

                return  back()->with($msgAndStatus)->withInput();
            }
        }




        $roleUpadte = $user->roles()->sync($request->get('role'));

        if($update==false && (!empty($roleUpadte['attached']) || !empty($roleUpadte['detached']) || !empty($roleUpadte['updated']))){

            $update = true;
        }

        if($update){

            $array = [
                "subject_id" =>$id,
                "subject_type" =>"App\\User",
                "name" =>"updated_user",
                "key_name" =>$user->email,
                "auth_id" => Auth::user()->id,
                "auth_type" => Auth::getProvider()->getModel()
            ];

            $normalActivity->createActivity($array);


            $msgAndStatus = [
                "success" => "Updated"
            ];

            return redirect("users")->with($msgAndStatus);

        }

        $msgAndStatus = [
           "error" => "Not Updated"
       ];

        return redirect("users")->with($msgAndStatus);




    }

    public function setAndGetSubjectMatters($subject_id,$name,$key_name){

        $sujectMatters=array(
            "subject_id" => $subject_id,
            "name" => $name,
            "key_name" => $key_name
        );

        return $sujectMatters;

    }

//    public function destroy(Request $request){
//
//        $response=array();
//
//        $userId=$request->get('deleteUser');
//
//        $deleted=User::destroy($userId);
//
//        if($deleted >= 1){
//
//            $response['status'] =1;
//            $response['msg'] ='Deleted';
//        }else{
//
//            $response['status'] =0;
//            $response['msg'] ='Not Deleted';
//
//        }
//
//        return response()->json($response);
//
//        //return User::destroy($userId);
//    }
}
