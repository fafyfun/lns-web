<?php
/**
 * Created by PhpStorm.
 * User: mulaffer
 * Date: 12/3/16
 * Time: 11:21 AM
 */

namespace App\SubjectRepository;

use App\Activity;
use Illuminate\Http\Request;
use ReflectionClass;
use App\PermissionRole as PR;

class PermissionRole implements Subject
{
    protected $className;

    public function  __construct()
    {
        $this->className =(new ReflectionClass($this))->getShortName();
    }

    public function deletedActivity() {

        $linkArray=[];

        $name = strtolower($this->className);

        $deletedItems=Activity::select('subject_id','key_name')->where('name','deleted_'.$name)->latest()->paginate(10);

        return $this->checkDeletedItemCount($deletedItems,$linkArray);
    }




    public function checkDeletedItemCount($deletedItems,$linkArray){

        if($deletedItems->count() > 0){

            $linkArray = $this->loopThroughDeletedItems($deletedItems,$linkArray);

            $classItems=$this->setAndGetViewItems(str_plural(strtolower($this->className)));

            $linkCollection=collect($linkArray);

            return view('activities.deleted.show', compact(['linkCollection','classItems','deletedItems']));

        }

        $classItems=$this->setAndGetViewItems("no_data");

        $linkCollection=collect($linkArray);

        return view('activities.deleted.show', compact(['linkCollection','classItems']));
    }

    public function setAndGetViewItems($view){


        $classItems=array(
            "view" =>$view,
            "header" =>str_plural($this->className),
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "permissionRoleActive" =>"active",
            "permissionRoleIn" =>"in",
            "deletedPermissionRoleActive" =>"active"
        );

        return $classItems;
    }

    public function loopThroughDeletedItems($deletedItems,$linkArray){

        foreach ($deletedItems as $di){
            $linkArray["$di->key_name-$di->subject_id"]=url("/activities/$di->subject_id/".$this->className);
        }
        //dd($linkArray);
        return $linkArray;

    }

    public function search(Request $request) {

        $search = trim($request->get('search'));  //search keyword
        $allId = [];

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "permissionRoleActive" =>"active",
            "permissionRoleIn" =>"in",
            "managePermissionRoleActive" =>"active"
        ];

        if($search != '' ){

            $pr = new PR;

            $perPage=10;

            $getAssignedPermission=$pr->getAssignedPermission($perPage,$search);

            // pass searched key to the pagination link param
            $getAssignedPermission->appends(['search' => $search]);

            $allId=$this->checkArrayCount($getAssignedPermission,$allId);

            $getAssignedPermissionIds=collect($allId);

            return view('permissionrole.show',compact(['getAssignedPermissionIds','getAssignedPermission','search','classItems']));
        }

        return redirect("permissionrole");

    }



    public function checkArrayCount($arrays,$allId){

        if(count($arrays) > 0){

            return $this->loopThroughArrays($arrays,$allId);

        }

        return [];
    }

    public function loopThroughArrays($arrays,$allId){

        foreach($arrays as $array){

            array_push($allId,$array->permissionrole_id);
        }

        return $allId;

    }
}