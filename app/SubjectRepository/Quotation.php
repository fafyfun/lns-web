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


class Quotation implements Subject
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
            "quotationActive" => "active",
            "quotationIn" => "in",
            "manageQuotationActive" =>"active",
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

            'quotation' => trim($request->get('quotation')),
            'agent' => $request->get('agent'),
            'status' => $request->get('status'),
            'inquiry' => $request->get('inquiry')

        ];

        //dd($searchArray);


        $classItems=[
            "quotationActive" => "active",
            "quotationIn" => "in",
            "manageQuotationActive" =>"active",
        ];

        if( !empty( array_filter($searchArray) ) ){



            $quotations = $this->searchQuery($searchArray);

            // pass searched key to the pagination link param
            $quotations->appends([
                'quotation' => $searchArray['quotation'],
                'agent' => $searchArray['agent'],
                'status' => $searchArray['status'],
                'inquiry' => $searchArray['inquiry'],
            ]);

            $collectionId=$this->checkModelCount($quotations);

            $agents = \App\User::with('roles')->whereHas('roles',function ($query) {
                $query->whereIn('roles.name',['Sales Executive']);
            })->get();

            return view('quotations.show',compact(['quotations','collectionId','classItems','searchArray','agents']));


        }

        return redirect("quotations");

    }



    public function searchQuery($searchArray){

        /*
         *search By agent
        */

        //dd($searchArray);

        $bigQuery = \App\Quotation::with('inquiry','inquiry.agent');

        if($searchArray['agent']!=''){

            $bigQuery = $bigQuery->whereHas('inquiry',function ($query) use ($searchArray){
                $query->where('inquiries.agent_id',$searchArray['agent']);
            });

        }

        /*
         *search By status
        */

        if($searchArray['status']!=''){

            $bigQuery = $bigQuery->where('status', $searchArray['status']);
        }

        if($searchArray['inquiry']!=''){

            $bigQuery = $bigQuery->where('inquiry_id', $searchArray['inquiry']);
        }

        if($searchArray['quotation']!=''){

            $bigQuery = $bigQuery->where('id', $searchArray['quotation']);
        }

        return $bigQuery->paginate(10);


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