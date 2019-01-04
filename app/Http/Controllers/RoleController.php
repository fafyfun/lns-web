<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use Auth;
use App\ActivityRepository\NormalActivity;

class RoleController extends Controller
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
    public function index()
    {

        $collectionId = [];

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "roleActive" =>"active",
            "roleIn" =>"in",
            "manageRoleActive" =>"active"
        ];


        $roles = Role::paginate(10);

       // dd($roles->toArray()['data']);

            if($roles->count() > 0){

                $collectionId=$roles->pluck('id');

            }

        //$collectionId = collect($allId);

        return view('roles.show',compact(['roles','collectionId','classItems']));
    }

    public function loopThroughRoles($roles,$allId){

        foreach ($roles as $role){

            array_push($allId,$role->id);
        }

        return $allId;
    }

    /**,
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "roleActive" =>"active",
            "roleIn" =>"in",
            "createRoleActive" =>"active"
        ];

        return view('roles.create',compact(['classItems']));
    }

    /**
     * @param Request $request
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request, Role $role,NormalActivity $normalActivity)
    {
        $this->validate($request,[
            'name' => 'required|unique:roles',
            'shortname' => 'required|unique:roles|max:255',
        ]);

        $msgAndStatus = [
            "error" => "Not Inserted"
        ];

        $name = $request->get('name');

        $shortName = $request->get('shortname');

        $description = $request->get('description');

        $role->name = $name;

        $role->shortname = $shortName;

        $role->description = $description;

        if($role->isDirty()){

            $msgAndStatus = [
                "success" => "Inserted"
            ];
        }

        try{
            $role->save();


        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];

            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($role->id,"created_role",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("roles")->with($msgAndStatus);
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

        $role = Role::findOrFail($id);

        return view('roles.edit',compact(['role']));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request,NormalActivity $normalActivity,$id){

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

        $role = Role::find($id);

        $role->name = $name;

        $role->shortname = $shortName;

        $role->description = $description;

        if($role->isDirty()){

            $msgAndStatus = [
                "success" => "Updated"
            ];

        }

        try{
            $role->save();

        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {

                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];

            }
            return  back()->with($msgAndStatus)->withInput();
        }

        $sujectMatters=$this->setAndGetSubjectMatters($id,"updated_role",$name);

        $normalActivity->updateActivity($sujectMatters);

        return redirect("roles")->with($msgAndStatus);


    }

    /**
     * @param Request $request
     * @return int
     */
    public function destroy(Request $request,NormalActivity $normalActivity){


        $deletedRoles=[];

        $roleId = $request->get('deleteRole');

        foreach($roleId as $id){

            $role=Role::find($id);

            $deletedRoles[$id]=$role->name;
        }

        try{

            $deleted=Role::destroy($roleId);

        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];

            if ($error_code) {

                $response = $this->setDeleteResponse(0,$e->errorInfo[2]);

                return response()->json($response);


            }

        }


        if($deleted >= 1){

            $response=$this->setDeleteResponse(1,"Deleted");

            $this->loopThroughDeletedRoles($roleId,$deletedRoles,$normalActivity);

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

    public function loopThroughDeletedRoles($roleId,$deletedRoles,NormalActivity $normalActivity){

        foreach($roleId as $id){

            $sujectMatters=$this->setAndGetSubjectMatters($id,"deleted_role",$deletedRoles[$id]);

            $normalActivity->updateActivity($sujectMatters);
        }


    }


}