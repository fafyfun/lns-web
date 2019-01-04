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


class Salestarget implements Subject
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
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "salesTargetActive" =>"active",
            "salesTargetIn" =>"in",
            "manageSalesTargetActive" =>"active"
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

        // $search = trim($request->get('keyword'));  //search keyword
        $allId = [];

        $searchArray=[

            'keyword' => trim($request->get('keyword')),
            'agent' => $request->get('agent')

        ];

        //dd($searchArray);


        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "salesTargetActive" =>"active",
            "salesTargetIn" =>"in",
            "manageSalesTargetActive" =>"active"
        ];

        if( !empty( array_filter($searchArray) ) ){



            $salestargets = $this->searchQuery($searchArray);

            // pass searched key to the pagination link param
            $salestargets->appends([
                'keyword' => $searchArray['keyword'],
                'agent' => $searchArray['agent']
            ]);

            $collectionId=$this->checkModelCount($salestargets);

            $agents = \App\User::with('roles')->whereHas('roles',function ($query) {
                $query->whereIn('roles.name',['Sales Executive']);
            })->get();

            return view('salestargets.show',compact(['salestargets','collectionId','classItems','searchArray','agents']));


        }

        return redirect("salestarget");

    }



    public function searchQuery($searchArray){

        /*
         *search By agent
        */

        //dd($searchArray);

        $bigQuery = \App\Salestarget::with('agent');

        if($searchArray['agent']!=''){

            $bigQuery = $bigQuery->where('agent_id',$searchArray['agent']);

        }



        if($searchArray['keyword']!=''){

            $bigQuery = $bigQuery->where('year',$searchArray['keyword']);

        }

        return $bigQuery->paginate(120);


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