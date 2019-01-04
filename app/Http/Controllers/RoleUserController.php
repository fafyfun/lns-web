<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Role;
use Validator;
use Auth;
use App\RoleUser;
use App\ActivityRepository\NormalActivity;

//use Carbon\Carbon ;


class RoleUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(RoleUser $ru)
    {

        $classItems=[
            "roleUserActive" =>"active",
            "manageRoleUserActive" =>"active"
        ];

        $perPage=2;

        $allId=[];


            $getUserAssignedRole=$ru->getUserAssignedRole($perPage);


            foreach ($getUserAssignedRole as $uar){

                array_push($allId, $uar->roleuser_id);
            }

            $getUserAssignedRoleIds=collect($allId);

        return view('roleuser.show',compact(['getUserAssignedRoleIds','getUserAssignedRole','classItems']));


    }


    public function create()
    {
        $classItems=[
            "roleUserActive" =>"active",
            "createRoleUserActive" =>"active"
        ];

        $users = User::select('id','email')->get();

        $roles = Role::select('id','name')->get();

        return view('roleuser.create',compact(['users','roles','classItems']));
    }

    public function store(Request $request,NormalActivity $normalActivity)
    {

        $this->validate($request, [
            'user' => 'required',
            'role' => 'required',
        ]);

        $msgAndStatus = [
            "error" => "Not Inserted"
        ];

        $userId=$request->get('user');
        $roleId=$request->get('role');

        //dd($userId,$roleId);

        $user = User::find($userId);

        try{
            $user->roles()->attach($roleId);

            $roleuser =$user->roles()->with('users')->wherePivot('role_id',$roleId)->get();
           // dd($roleuser);

            $key_name =$this->loopThroughRoleUser($roleuser);

            $array = [
                "subject_id" =>$roleuser[0]->pivot->id,
                "subject_type" =>"App\\RoleUser",
                "name" =>"created_roleuser",
                "key_name" =>$key_name,
                "auth_id" => Auth::user()->id,
                "auth_type" => Auth::getProvider()->getModel()
            ];

            $normalActivity->createActivity($array);  // subject types according to alphabet order

            $msgAndStatus = [
                "success" => "Inserted"
            ];

        }catch (\Illuminate\Database\QueryException $e) {


            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];
            }
            return  back()->with($msgAndStatus)->withInput();
        }

        return redirect("roleuser")->with($msgAndStatus);

    }

    public function loopthroughRoleUser($roleuser){

        foreach($roleuser[0]->users as $ru){

            $key_name = $this->checkCondition($ru,$roleuser);

        }

        return $key_name;
    }

    public function checkCondition($ru,$roleuser){


        if(($ru->pivot->user_id == $roleuser[0]->pivot->user_id) && ($ru->pivot->role_id == $roleuser[0]->pivot->role_id)){

            return $ru->name."-".$roleuser[0]->name;
        }
    }


    public function destroy(Request $request,NormalActivity $normalActivity){

        $roleUserIds = $request->get('deleteRoleUser');


        foreach ($roleUserIds as $ruids){

              $ids=explode(",",$ruids);

              $roleId=$ids[0];

              $userId=$ids[1];

            $roleuser = User::find($userId)->roles()->with('users')->wherePivot('role_id',$roleId)->get();

            $key_name =$this->loopThroughRoleUser($roleuser);

            $array = [
                "subject_id" =>$roleuser[0]->pivot->id,
                "subject_type" =>"App\\RoleUser",
                "name" =>"deleted_roleuser",
                "key_name" =>$key_name,
                "auth_id" => Auth::user()->id,
                "auth_type" => Auth::getProvider()->getModel()
            ];

            $normalActivity->createActivity($array);

            $deleted = User::find($userId)->roles()->detach($roleId);
        }

        if($deleted >= 1){

            $response=$this->setDeleteResponse(1,"Deleted");

            return response()->json($response);
        }

        $response = $this->setDeleteResponse(0,"Not Deleted");

        return response()->json($response);
    }

    public function setDeleteResponse($status,$msg){

        $response = [
            'status' => $status,
            'msg' => $msg

        ];

        return $response;
    }


}
