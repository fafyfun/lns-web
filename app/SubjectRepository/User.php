<?php
/**
 * Created by PhpStorm.
 * User: mulaffer
 * Date: 11/24/16
 * Time: 1:55 PM
 */

namespace App\SubjectRepository;
use App\Activity;
use Illuminate\Http\Request;
use ReflectionClass;


class User implements Subject
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
             "userActive" =>"active",                  //need to change
             "userIn" => "in",
            "deletedUserActive" =>"active"            //need to change
         );

        return $classItems;
    }

    public function loopThroughDeletedItems($deletedItems,$linkArray){

        foreach ($deletedItems as $di){
            $linkArray["$di->key_name-$di->subject_id"]="activities/$di->subject_id/".$this->className;
        }

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
            "userActive" =>"active",
            "userIn" => "in",
            "manageUserActive" =>"active"
        ];

        if($search != '' ){

            $users=$this->searchQuery($search);

            // pass searched key to the pagination link param
            $users->appends(['search' => $search]);

            $allId=$this->checkModelCount($users,$allId);


            $collectionId = collect($allId);

            return view('users.show',compact(['users','search','collectionId','classItems']));
        }

        return redirect("users");

    }



    public function searchQuery($keyword){

        return \App\User::where('id', '=', $keyword)
            ->orwhere('name', 'like', "%$keyword%")
            ->orWhere('phone_number', 'like', "%$keyword%")
            ->orWhere('email', 'like', "%$keyword%")->paginate(10);
    }

    public function checkModelCount($models,$allId){

        if($models->count() > 0){

            return $this->loopThroughModels($models,$allId);

        }

        return [];
    }

    public function loopThroughModels($models,$allId){

        foreach ($models as $model){
            array_push($allId,$model->id);
        }

        return $allId;

    }

}