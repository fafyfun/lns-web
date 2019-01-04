<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Auth;
use App\ActivityRepository\NormalActivity;

class PermissionController extends Controller
{
    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $collectionId = [];

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "permissionActive" =>"active",
            "permissionIn" =>"in",
            "managePermissionActive" =>"active"
        ];


            //fetch all users records
            $permissions = Permission::paginate(10);

           // dd($permissions);

            if($permissions->count() > 0){

                $collectionId=$permissions->pluck('id');


            }
            //$collectionId = collect($allId);



        return view('permissions.show',compact(['permissions','collectionId','classItems']));
    }

    public function loopThroughPermissions($permissions,$allId){

        foreach ($permissions as $permission){

            array_push($allId,$permission->id);

        }

        return $allId;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "permissionActive" =>"active",
            "permissionIn" =>"in",
            "createPermissionActive" =>"active"
        ];


        return view('permissions.create',compact(['classItems']));
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Permission $permission,NormalActivity $normalActivity)
    {

        $this->validate($request,[
            'name' => 'required|unique:permissions',
            'shortname' => 'required|unique:permissions|max:255',
        ]);

        $msgAndStatus = [
            "error" => "Not Inserted"
        ];

        $name = $request->get('name');
        $shortName = $request->get('shortname');
        $description = $request->get('description');

        $permission->name = $name;
        $permission->shortname = $shortName;
        $permission->description = $description;

        if($permission->isDirty()){

            $msgAndStatus = [
                "success" => "Inserted"
            ];

        }



        try{
            $permission->save();

        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];


            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($permission->id,"created_permission",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("permissions")->with($msgAndStatus);
    }

    public function setAndGetSubjectMatters($subject_id,$name,$key_name){

        $sujectMatters=array(
            "subject_id" => $subject_id,
            "name" => $name,
            "key_name" => $key_name
        );

        return $sujectMatters;

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){

        $permission = Permission::findOrFail($id);

        return view('permissions.edit',compact(['permission']));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id,NormalActivity $normalActivity){

        $this->validate($request,[
            'name' => 'required',
            'shortname' => 'required',
        ]);

        $msgAndStatus = [
            "error" => "Not Updated"
        ];

        $name = trim($request->get('name'));
        $shortName = trim($request->get('shortname'));
        $description = trim($request->get('description'));

        $permission = Permission::find($id);

        $permission->name = $name;
        $permission->shortname = $shortName;
        $permission->description = $description;

        if($permission->isDirty()){

            $msgAndStatus = [
                "success" => "Updated"
            ];
        }

        try{
            $permission->save();

        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];
            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($id,"updated_permission",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("permissions")->with($msgAndStatus);


    }

    /**
     * @param Request $request
     * @return int
     */
    public function destroy(Request $request,NormalActivity $normalActivity){


        $deletedPermissions=[];

        $permissionId = $request->get('deletePermission');

        foreach($permissionId as $id){

            $permission=Permission::find($id);

            $deletedPermissions[$id]=$permission->name;
        }

        try{
            $deleted=Permission::destroy($permissionId);
        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];

            if ($error_code) {

                $response = $this->setDeleteResponse(0,$e->errorInfo[2]);

                return response()->json($response);


            }

        }


        if($deleted >= 1){

            $response=$this->setDeleteResponse(1,"Deleted");

             $this->loopThroughDeletedPermissions($permissionId,$deletedPermissions,$normalActivity);

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

    public function loopThroughDeletedPermissions($permissionId,$deletedPermissions,NormalActivity $normalActivity){

        foreach($permissionId as $id){

            $sujectMatters=$this->setAndGetSubjectMatters($id,"deleted_permission",$deletedPermissions[$id]);
            //return response()->json($sujectMatters);
            $normalActivity->updateActivity($sujectMatters);
        }


    }
}
