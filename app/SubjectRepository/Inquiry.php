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


class Inquiry implements Subject
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
            "manageInquiryActive" =>"active"   //need to change
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
            'agent' => $request->get('agent'),
            'status' => $request->get('status'),
            'customer' => $request->get('customer'),
            'inquiry_source' => $request->get('inquiry_source')

        ];

        //dd($searchArray);


        $classItems=[
            "salesInquiryActive" => "active",
            "salesInquiryIn" => "in",
            "leadOrInquiryActive" =>"active",    //need to change
            "leadOrInquiryIn" =>"in",        //need to change
            "manageInquiryActive" =>"active"   //need to change
        ];

        if( !empty( array_filter($searchArray) ) ){



            $inquiries = $this->searchQuery($searchArray);

            // pass searched key to the pagination link param
            $inquiries->appends([
                'keyword' => $searchArray['keyword'],
                'agent' => $searchArray['agent'],
                'status' => $searchArray['status'],
                'inquiry_source' => $searchArray['inquiry_source'],
                'customer' => $searchArray['customer']
            ]);

            $collectionId=$this->checkModelCount($inquiries);

            $agents = \App\User::with('roles')->whereHas('roles',function ($query) {
                $query->whereIn('roles.name',['Sales Executive']);
            })->get();

            return view('inquiries.show',compact(['inquiries','collectionId','classItems','searchArray','agents']));


        }

        return redirect("inquiries");

    }



    public function searchQuery($searchArray){

        /*
         *search By agent
        */

        //dd($searchArray);

        $bigQuery = \App\Inquiry::with('saleslead','saleslead.customer','agent');

        if($searchArray['agent']!=''){

            $bigQuery = $bigQuery->where('agent_id',$searchArray['agent']);

        }

        /*
         *search By status
        */

        if($searchArray['status']!=''){

            $bigQuery = $bigQuery->where('status', $searchArray['status']);
        }

        if($searchArray['inquiry_source']!=''){

            $bigQuery = $bigQuery->where('inquiry_source', $searchArray['inquiry_source']);
        }

        if($searchArray['customer']!=''){

            $key=$searchArray['customer'];
            $bigQuery=$bigQuery ->whereHas('saleslead.customer',function ($query)use($key){
                $query->where('customers.name', 'like', "%$key%")
                    ->orWhere('customers.address', 'like', "%$key%")
                    ->orWhere('customers.mobile', 'like', "%$key%")
                    ->orWhere('customers.telephone', 'like', "%$key%")
                    ->orWhere('customers.email', 'like', "%$key%");
            });

        }

        if($searchArray['keyword']!=''){

            $bigQuery = $bigQuery->where('id',$searchArray['keyword']);

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