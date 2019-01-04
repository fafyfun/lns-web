<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\PermissionRole;
use Validator;
use Auth;
use App\ActivityRepository\NormalActivity;

class PermissionRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(PermissionRole $pr)
    {
        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "permissionRoleActive" =>"active",
            "permissionRoleIn" =>"in",
            "managePermissionRoleActive" =>"active"
        ];

        $perPage=10;
        $getAssignedPermissionIds=[];

            $getAssignedPermission=$pr->getAssignedPermission($perPage);

            if($getAssignedPermission->count() > 0){

                $getAssignedPermissionIds = $getAssignedPermission->pluck('permissionrole_id');

            }


//            foreach ($getAssignedPermission as $ap){
//
//                array_push($allId, $ap->permissionrole_id);
//            }

          //$getAssignedPermissionIds=collect($allId);


        return view('permissionrole.show',compact(['getAssignedPermissionIds','getAssignedPermission','classItems']));
    }


    public function create()
    {
        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "permissionRoleActive" =>"active",
            "permissionRoleIn" =>"in",
            "createPermissionRoleActive" =>"active"
        ];

        $permissions = Permission::select('id','name')->get();

        $roles = Role::select('id','name')->get();

        return view('permissionrole.create',compact(['permissions','roles','classItems']));
    }

    public function store(Request $request,NormalActivity $normalActivity)
    {
        $this->validate($request, [
            'permission' => 'required',
            'role' => 'required',
        ]);

        $permissionIds=$request->get('permission');
        $roleId=$request->get('role');

        $role = Role::find($roleId);
        try{
            foreach ($permissionIds as $permissionId){

                $role->permissions()->attach($permissionId);

                $permissionrole =$role->permissions()->with('roles')->wherePivot('permission_id',$permissionId)->get();

                $key_name =$this->loopThroughPermissionRole($permissionrole);

                $array = [
                    "subject_id" =>$permissionrole[0]->pivot->id,
                    "subject_type" =>"App\\PermissionRole",
                    "name" =>"created_permissionrole",
                    "key_name" =>$key_name,
                    "auth_id" => Auth::user()->id,
                    "auth_type" => Auth::getProvider()->getModel()
                ];

                $normalActivity->createActivity($array);
            }

            $msgAndStatus = [
                "success" => "Inserted"
            ];

        }catch (\Illuminate\Database\QueryException $e) {

            $error_code = $e->errorInfo[1];
            //dd($error_code);
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];

            }
            return  back()->with($msgAndStatus)->withInput();
        }

        return redirect("permissionrole")->with($msgAndStatus);;

    }

    public function loopThroughPermissionRole($permissionrole){

        foreach($permissionrole[0]->roles as $pr){

            $key_name = $this->checkCondition($pr,$permissionrole);

        }

        return $key_name;
    }

    public function checkCondition($pr,$permissionrole){


        if(($pr->pivot->permission_id == $permissionrole[0]->pivot->permission_id) && ($pr->pivot->role_id == $permissionrole[0]->pivot->role_id)){

            return $pr->name."-".$permissionrole[0]->name;
        }
    }

//    public function edit(Request $request,$permissionId,$roleId){
//
//
//        $roles = Role::select('id','name')->get();
//        $permissions = Permission::select('id','email')->get();
//
//        return view('permissionrole.edit',compact(['permissions','roles','permissionId','roleId']));
//    }

    public function destroy(Request $request,NormalActivity $normalActivity){

        $permissionRoleIds = $request->get('deletePermissionRole');


        foreach ($permissionRoleIds as $prids){

            $ids=explode(",",$prids);
            $permissionId=$ids[0];
            $roleId=$ids[1];

            $permissionrole = Role::find($roleId)->permissions()->with('roles')->wherePivot('permission_id',$permissionId)->get();

            $key_name =$this->loopThroughPermissionRole($permissionrole);

            $array = [
                "subject_id" =>$permissionrole[0]->pivot->id,
                "subject_type" =>"App\\PermissionRole",
                "name" =>"deleted_permissionrole",
                "key_name" =>$key_name,
                "auth_id" => Auth::user()->id,
                "auth_type" => Auth::getProvider()->getModel()
            ];

            $normalActivity->createActivity($array);

            $deleted = Role::find($roleId)->permissions()->detach($permissionId);

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
