<?php

namespace App\Http\Controllers;

use App\Inquiry;
use App\Saleslead;
use Illuminate\Http\Request;
use App\ActivityRepository\NormalActivity;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $classItems=[
            "salesInquiryActive" => "active",
            "salesInquiryIn" => "in",
            "leadOrInquiryActive" =>"active",
            "leadOrInquiryIn" =>"in",
            "manageInquiryActive" =>"active"
        ];

        $agents = User::with('roles')->whereHas('roles',function ($query) {
            $query->whereIn('roles.name',['Sales Executive']);
        })->get();

        $inquiries = Inquiry::with('saleslead','saleslead.customer','agent')->paginate(10);

        //dd($inquiries);
        if($inquiries->count() > 0){
            $collectionId=$inquiries->pluck('id');
        }
        return view('inquiries.show',compact(['inquiries','collectionId','classItems','agents']));
    }

    public function convert(Request $request,$id,Inquiry $inquiry,NormalActivity $normalActivity)
    {

//        $this->validate($request,[
//            'planned_visit_date_time' => 'required',
//            'inquiry_source' => 'required',
//            'maximum_discount' => 'required',
//            'actual_visit_date_time' => 'requireds',
//        ]);

        $msgAndStatus = [
            "error" => "Not Converted"
        ];
        DB::beginTransaction();
        $inquiry->saleslead_id = $id;
        $email = explode('-',$request->get('agent'))[1];
        $agent = User::where('email',$email)->first();
        $inquiry->agent_id = $agent->id;
        $inquiry->status = 1;
        $existingSalesLead = Saleslead::find($id);
        $existingSalesLead->status = 2;
        $existingCustomer = Saleslead::with('customer')->where('id',$id)->first();
        $inquiry->planned_visit_date_time = $request->get('planned_visit_date_time');
        $inquiry->inquiry_source = 1;
        $inquiry->maximum_discount = $request->get('maximum_discount');
        $inquiry->actual_visit_date_time = $request->get('actual_visit_date_time');
        $inquiry->created_by = Auth::user()->id;
        if($inquiry->isDirty()){
            $msgAndStatus = [
                "success" => "Converted"
            ];
        }

        try{
            $inquiry->save();
            $sujectMatters=$this->setAndGetSubjectMatters($inquiry->id,"created_inquiry",$existingCustomer->customer->name);
            $normalActivity->updateActivity($sujectMatters);

            $existingSalesLead->save();
            $array = [
                "subject_id" =>$id,
                "subject_type" =>"App\\Saleslead",
                "name" =>"updated_saleslead",
                "key_name" =>$existingCustomer->customer->name,
                "auth_id" => Auth::user()->id,
                "auth_type" => Auth::getProvider()->getModel()
            ];
            $normalActivity->createActivity($array);

        }catch(\Illuminate\Database\QueryException $e){

                DB::rollBack();
            $error_code = $e->errorInfo[1];
            if ($error_code) {
                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];
            }

            return $msgAndStatus;
        }
        DB::commit();
        return $msgAndStatus;



    }

    public function setAndGetSubjectMatters($subject_id,$name,$key_name){
        $sujectMatters=array(
            "subject_id" => $subject_id,
            "name" => $name,
            "key_name" => $key_name
        );
        return $sujectMatters;
    }

    public function view($id){

        $inquiry = Inquiry::with('saleslead.customer','agent')
                    ->where('id',$id)
                    ->first();

        return view('inquiries.view',compact(['inquiry']));
    }

    public function canReschedule($id){

        $inquiry = Inquiry::with('quotations','agent')
            ->where('id',$id)
            ->get();

        if($inquiry[0]->status == 2 && $inquiry[0]->quotations->isNotEmpty() && $inquiry[0]->quotations->pluck('status')->contains('2')){

            return [
                'status' => 400,
                'message' => 'Can not Reschedule',
                'data' => null
            ];

        }

        $inquiry->map(function ($item, $key){
            $item['agent_name'] = $item['agent']['name'].'-'.$item['agent']['email'];
            unset($item['agent']);
        });

        return [
            'status' => 200,
            'message' => 'Can Reschedule',
            'data' => $inquiry[0]
        ];



    }

    public function reschedule($id,Request $request,NormalActivity $normalActivity){

        $msgAndStatus = [
            "error" => "Not Rescheduled"
        ];

        $inquiry = Inquiry::with('saleslead.customer')->find($id);
        $email = explode('-',$request->get('agent'))[1];
        $agent = User::where('email',$email)->first();
        $inquiry->agent_id = $agent->id;
        $inquiry->planned_visit_date_time = $request->get('planned_visit_date_time');
        //$inquiry->actual_visit_date_time = $request->get('actual_visit_date_time');

        if($inquiry->isDirty()){
            $msgAndStatus = [
                "success" => "Rescheduled"
            ];

            if($inquiry->status == 3){

                $inquiry->status = 1;
                $inquiry->cancel_reason = NULL;

            }
        }

        try{
            $inquiry->save();
            $sujectMatters=$this->setAndGetSubjectMatters($inquiry->id,"updated_inquiry",$inquiry->saleslead->customer->name);
            $normalActivity->updateActivity($sujectMatters);

        }catch(\Illuminate\Database\QueryException $e){

            $error_code = $e->errorInfo[1];
            if ($error_code) {
                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];
            }

            return $msgAndStatus;
        }

        return $msgAndStatus;

    }


}
