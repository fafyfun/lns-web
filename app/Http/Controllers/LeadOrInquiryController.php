<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Inquiry;
use App\Saleslead;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ActivityRepository\NormalActivity;

class LeadOrInquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $classItems=[
            "salesInquiryActive" => "active",
            "salesInquiryIn" => "in",
            "leadOrInquiryActive" =>"active",
            "leadOrInquiryIn" =>"in",
            "createLeadOrInquiryActive" =>"active"
        ];
        return view('leadorinquiry.create',compact(['classItems']));
    }

    public function getCustomerEmails(Request $request)
    {
        $query = $request->get('query');
        return Customer::select('email')->where('email', 'like', "%$query%")->paginate(10)->pluck('email');
    }

    public function getCustomerDetails(Request $request)
    {
        return Customer::where('email',$request->get('email' ) )->paginate(10);
    }

    public function getAgents(Request $request)
    {
        $query = $request->get('query');
        $results =  User::with('roles')->whereHas('roles',function ($query) {
            $query->where('roles.name','Sales Executive');
        })->select('name','email')->where('name', 'like', "%$query%")->paginate(10);
        $data=[];
        foreach ($results as $result) {
            $val = $result->name . '-' . $result->email;
            array_push($data, $val);
        }
        return $data;
    }

    public function store(Request $request,Customer $customer,Saleslead $saleslead,Inquiry $inquiry,NormalActivity $normalActivity)
    {
        $this->validate($request,[
            'name' => 'required|max:255',
            'address' => 'required',
            'mobile' => 'required|digits_between:9,10',
            'email' => 'required|email|max:255',
        ]);
        $existingCustomer = Customer::where('email',$request->get('email') )->first();
        //dd($existingCustomer);
        //when create inquiry later was clicked and user already exist
        if( $request->get('customer') && $existingCustomer == null){
            $flag = 1;
            $this->validate($request,[
                'email' => 'unique:customers',
            ]);
            $newCustomer = $this->createCustomer($request,$customer,$normalActivity,$flag);
            if (array_key_exists("error",$newCustomer)){
                $msgAndStatus = $newCustomer;
                return  back()->with($msgAndStatus)->withInput();
            }
            $msgAndStatus = $this->createSalesLead($saleslead,$newCustomer,$normalActivity,$flag);
            if (array_key_exists("error",$msgAndStatus)){
                return  back()->with($msgAndStatus)->withInput();
            }
            return  back()->with($msgAndStatus);
        }
        //when create inquiry later was clicked and user not exist
        if( $request->get('customer') && $existingCustomer != null){
            $flag = 2;
            $msgAndStatus = $this->createSalesLead($saleslead,$existingCustomer,$normalActivity,$flag);
            if (array_key_exists("error",$msgAndStatus)){
                return  back()->with($msgAndStatus)->withInput();
            }
            return  back()->with($msgAndStatus);
        }
        //when done was clicked
        $this->validate($request,[
            'agent' => 'required',
            'planned_visit_date_time' => 'required',
           // 'inquiry_source' => 'required',
            'maximum_discount' => 'required|integer|between:1,100',
            //'actual_visit_date_time' => 'required',
        ]);
        if( $request->get('inquiry') && $existingCustomer == null){
            $flag = 3;
            $newCustomer = $this->createCustomer($request,$customer,$normalActivity,$flag);
            if (array_key_exists("error",$newCustomer)){
                $msgAndStatus = $newCustomer;
                return  back()->with($msgAndStatus)->withInput();
            }
            $newSalesLead = $this->createSalesLead($saleslead,$newCustomer,$normalActivity,$flag);
            if (array_key_exists("error",$newSalesLead)){
                $msgAndStatus = $newSalesLead;
                return  back()->with($msgAndStatus)->withInput();
            }
            $msgAndStatus = $this->createInquiry($request,$inquiry,$newSalesLead,$newCustomer,$normalActivity,$flag);
            if (array_key_exists("error",$msgAndStatus)){
                return  back()->with($msgAndStatus)->withInput();
            }
            return  back()->with($msgAndStatus);
        }

        if( $request->get('inquiry') && $existingCustomer != null){
            $flag = 4;
            $newSalesLead = $this->createSalesLead($saleslead,$existingCustomer,$normalActivity,$flag);
            if (array_key_exists("error",$newSalesLead)){
                $msgAndStatus = $newSalesLead;
                return  back()->with($msgAndStatus)->withInput();
            }
            $msgAndStatus = $this->createInquiry($request,$inquiry,$newSalesLead,$existingCustomer,$normalActivity,$flag);
            if (array_key_exists("error",$msgAndStatus)){
                return  back()->with($msgAndStatus)->withInput();
            }
            return  back()->with($msgAndStatus);
        }
    }

    public function setAndGetSubjectMatters($subject_id,$name,$key_name){
        $sujectMatters=array(
            "subject_id" => $subject_id,
            "name" => $name,
            "key_name" => $key_name
        );
        return $sujectMatters;
    }

    public function createCustomer($request,$customer,$normalActivity,$flag){
        if($flag == 1 || $flag == 3){
            DB::beginTransaction();
        }
        $msgAndStatus = [
            "error" => "Not Inserted"
        ];
        $customer->name = trim($request->get('name'));
        $customer->email = trim($request->get('email'));
        $customer->mobile = trim($request->get('mobile'));
        $customer->telephone = trim($request->get('telephone'));
        $customer->address = trim($request->get('address'));
        try{
            $customer->save();
            $sujectMatters=$this->setAndGetSubjectMatters($customer->id,"created_customer",$customer->name);
            $normalActivity->updateActivity($sujectMatters);
        }catch(\Illuminate\Database\QueryException $e){
            if($flag == 1 || $flag == 3){
                DB::rollBack();
            }
            $error_code = $e->errorInfo[1];
            if ($error_code) {
                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];
            }
            return $msgAndStatus;
        }
        return $customer;
    }

    public function createSalesLead($saleslead,$existingCustomer,$normalActivity,$flag){
        if($flag == 2 || $flag == 4){
            DB::beginTransaction();
        }
        $msgAndStatus = [
            "error" => "Not Inserted"
        ];
        $saleslead->customer_id = $existingCustomer->id;
        $saleslead->lead_source = 1;
        $saleslead->status = 1;
        if($saleslead->isDirty()){
            $msgAndStatus = [
                "success" => "Inserted"
            ];
        }
        try{
            $saleslead->save();
            $array = [
                "subject_id" =>$saleslead->id,
                "subject_type" =>"App\\Saleslead",
                "name" =>"created_saleslead",
                "key_name" =>$existingCustomer->name,
                "auth_id" => Auth::user()->id,
                "auth_type" => Auth::getProvider()->getModel()
            ];
            $normalActivity->createActivity($array);

        }catch(\Illuminate\Database\QueryException $e){
            if($flag == 1 || $flag == 2 || $flag == 3 || $flag == 4){
                DB::rollBack();
            }
            $error_code = $e->errorInfo[1];
            if ($error_code) {
                $msgAndStatus = [
                    "error" => $e->errorInfo[2]
                ];
            }
            return $msgAndStatus;
        }
        DB::commit();
        if($flag == 1 || $flag == 2){
            return $msgAndStatus;
        }
        return $saleslead;
    }

    public function createInquiry($request,$inquiry,$existingSalesLead,$existingCustomer,$normalActivity,$flag){
        $msgAndStatus = [
            "error" => "Not Inserted"
        ];
        $inquiry->saleslead_id = $existingSalesLead->id;
        $email = explode('-',$request->get('agent'))[1];
        $agent = User::where('email',$email)->first();
        $inquiry->agent_id = $agent->id;
        $inquiry->status = 1;
        $existingSalesLead->status = 2;
        $inquiry->planned_visit_date_time = $request->get('planned_visit_date_time');
        $inquiry->inquiry_source = 1;
        $inquiry->maximum_discount = $request->get('maximum_discount');
        //$inquiry->actual_visit_date_time = $request->get('actual_visit_date_time');
        $inquiry->created_by = Auth::user()->id;
        if($inquiry->isDirty()){
            $msgAndStatus = [
                "success" => "Inserted"
            ];
        }

        try{
            $inquiry->save();
            $sujectMatters=$this->setAndGetSubjectMatters($inquiry->id,"created_inquiry",$existingCustomer->name);
            $normalActivity->updateActivity($sujectMatters);

            $existingSalesLead->save();

        }catch(\Illuminate\Database\QueryException $e){
            if($flag == 3 || $flag == 4){
                DB::rollBack();
            }
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
}
