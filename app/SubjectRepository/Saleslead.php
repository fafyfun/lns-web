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


class Saleslead implements Subject
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
            "salesInquiryActive" => "active",
            "salesInquiryIn" => "in",
            "leadOrInquiryActive" =>"active",    //need to change
            "leadOrInquiryIn" =>"in",        //need to change
            "manageLeadActive" =>"active"   //need to change
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
            'source' => $request->get('source'),
            'status' => $request->get('status'),

        ];

        //dd($searchArray);


        $classItems=[
            "salesInquiryActive" => "active",
            "salesInquiryIn" => "in",
            "leadOrInquiryActive" =>"active",    //need to change
            "leadOrInquiryIn" =>"in",        //need to change
            "manageLeadActive" =>"active"   //need to change
        ];

        if( !empty( array_filter($searchArray) ) ){

            $leads=$this->searchQuery($searchArray);

            // pass searched key to the pagination link param
            $leads->appends([
                'keyword' => $searchArray['keyword'],
                'source' => $searchArray['source'],
                'status' => $searchArray['status'],
            ]);

            $collectionId=$this->checkModelCount($leads);

            return view('leads.show',compact(['leads','collectionId','classItems','searchArray']));


        }

        return redirect("leads");

    }



    public function searchQuery($searchArray){

        /*
         *search By source
        */

       // dd($searchArray);

        $bigQuery = \App\Saleslead::with('customer');

        if($searchArray['source']!=''){

            $bigQuery = $bigQuery->where('lead_source',$searchArray['source']);

        }

        /*
         *search By status
        */

        if($searchArray['status']!=''){

            $bigQuery = $bigQuery->where('status', $searchArray['status']);
        }

        if($searchArray['keyword']!=''){

            $key=$searchArray['keyword'];
            $bigQuery=$bigQuery ->whereHas('customer',function ($query)use($key){
                $query->where('customers.name', 'like', "%$key%")
                    ->orWhere('customers.address', 'like', "%$key%")
                    ->orWhere('customers.mobile', 'like', "%$key%")
                    ->orWhere('customers.telephone', 'like', "%$key%")
                    ->orWhere('customers.email', 'like', "%$key%");
            });

        }

        return $bigQuery->paginate(10);

//        return \App\Student::with('departments','alsubjects')->whereHas('departments',function ($query) {
//            $query->whereIn('departments.id',Auth::user()->departments->pluck('id')->toArray());
//        })->where('name', 'like', "%$keyword%")
//            ->orWhere('registrationnumber', 'like', "%$keyword%")
//            ->whereIn('faculty_id',Auth::user()->faculties->pluck('id')->toArray())
//            ->whereIn('course_id',Auth::user()->courses->pluck('id')->toArray())
//            ->paginate(10);


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