<?php

namespace App\SubjectRepository;
use App\Activity;
use Illuminate\Http\Request;
use ReflectionClass;

class Brand implements Subject
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
            "productDataActive"=>"active",
            "productDataIn" =>"in",
            "brandActive" =>"active",
            "brandIn" =>"in",
            "deletedBrandActive" =>"active"
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
            "brandActive" =>"active",
            "brandIn" => "in",
            "manageBrandActive" =>"active"
        ];

        if($search != '' ){

            $brands=$this->searchQuery($search);

            // pass searched key to the pagination link param
            $brands->appends(['search' => $search]);

            $allId=$this->checkModelCount($brands,$allId);


            $collectionId = collect($allId);

            return view('brands.show',compact(['brands','search','collectionId','classItems']));
        }

        return redirect("brands");

    }

    public function searchQuery($keyword){

        return \App\Brand::where('name', 'like', "%$keyword%")
            ->paginate(10);
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