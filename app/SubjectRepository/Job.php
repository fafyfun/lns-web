<?php
/**
 * Created by PhpStorm.
 * User: mulaffer
 * Date: 2/1/17
 * Time: 8:48 AM
 */

namespace App\SubjectRepository;
use App\Activity;
use Illuminate\Http\Request;
use ReflectionClass;


class Job implements Subject
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

            //dd($classItems);

            return view('activities.deleted.show', compact(['linkCollection','classItems','deletedItems']));

        }

        $classItems=$this->setAndGetViewItems("no_data");

        $linkCollection=collect($linkArray);

        return view('activities.deleted.show', compact(['linkCollection','classItems']));
    }

    public function setAndGetViewItems($view){


        $classItems=[
            "view" =>$view,
            "header" =>str_plural($this->className),
            "jobActive" => "active",
            "jobIn" => "in",
            "manageJobActive" =>"active",
        ];

        return $classItems;
    }

    public function loopThroughDeletedItems($deletedItems,$linkArray){

        foreach ($deletedItems as $di){
            $linkArray["$di->key_name-$di->subject_id"]=url("/activities/$di->subject_id/".$this->className);
        }



        return $linkArray;

    }

    public function search(Request $request) {

        $search = trim($request->get('search'));  //search keyword
        $allId = [];


        $classItems=[
            "jobActive" => "active",
            "jobIn" => "in",
            "manageJobActive" =>"active"
        ];

        if($search != '' ){

            $jobs=$this->searchQuery($search);

            // pass searched key to the pagination link param
            $jobs->appends(['search' => $search]);

            $allId=$this->checkModelCount($jobs,$allId);


            $collectionId = collect($allId);

            return view('jobs.show',compact(['jobs','search','collectionId','classItems']));
        }

        return redirect("jobs");

    }

    public function searchQuery($keyword){

        return \App\Quotationjob::where('id', 'like', "$keyword")
            ->paginate(10);
    }

    public function checkModelCount($models){

        if($models->count() > 0){

            return $models->pluck('id');

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