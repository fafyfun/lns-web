<?php

namespace App\Http\Controllers;

use App\ActivityRepository\NormalActivity;
use App\Installation;
use App\Mail\JobCard;
use App\Quotationjob;
use App\Quotation;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SnappyPDF;
use Illuminate\Support\Facades\Mail;


class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {



        $classItems=[
            "quotationActive" => "active",
            "quotationIn" => "in",
            "manageQuotationActive" =>"active",
        ];


        $quotations = Quotation::with('inquiry','inquiry.agent')->paginate(10);
        //dd($quotations);
        //dd($quotations->groupBy('inquiry_id'));

//        foreach ($quotations->groupBy('inquiry_id') as $quot){
//            dd($quot);
//        }
        //,'rooms','rooms.walls','rooms.walls.wallimages'

        // dd($roles->toArray()['data']);

        if($quotations->count() > 0){

            $collectionId=$quotations->pluck('id');

        }

        $agents = User::with('roles')->whereHas('roles',function ($query) {
            $query->whereIn('roles.name',['Sales Executive']);
        })->get();

        //$collectionId = collect($allId);

        return view('quotations.show',compact(['agents','quotations','collectionId','classItems']));
    }

    public function detail($id){

        $quotation = Quotation::with('inquiry','inquiry.agent','rooms','rooms.walls','rooms.walls.product','rooms.walls.wallimages')
            ->where('id',$id)
            ->first();
        //dd($quotation);

        return view('quotations.detail',compact(['quotation']));
    }

    public function approve($id,Request $request,NormalActivity $normalActivity,Quotationjob $quotationjob,Installation $installation){

        $quotation = Quotation::find($id);



        if($quotation->status == 2){

            return ["error" => "Already Approved"];

        }

        $msgAndStatus = [
            "error" => "Not Approved"
        ];

        DB::beginTransaction();
        $quotation->status = 2;

        if($quotation->isDirty()){
            $msgAndStatus = [
                "success" => "Approved"
            ];
        }

        try{
            $quotation->save();
            $array = [
                "subject_id" =>$quotation->id,
                "subject_type" =>"App\\Quotation",
                "name" =>"approved_quotation",
                "key_name" =>$quotation->id,
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

        $quotationjob->quotation_id = $quotation->id;
        $quotationjob->status = 1;

        try{
            $quotationjob->save();
            $array = [
                "subject_id" =>$quotationjob->id,
                "subject_type" =>"App\\Quotationjob",
                "name" =>"created_quotationjob",
                "key_name" =>$quotationjob->id,
                "auth_id" => Auth::user()->id,
                "auth_type" => Auth::getProvider()->getModel()
            ];
            $normalActivity->createActivity($array);

        }catch(\Illuminate\Database\QueryException $e){

            DB::rollBack();
            $error_code = $e->errorInfo[1];
            if ($error_code) {
                $msgAndStatus = [
                    "error" => $e->errorInfo[2]."quotejob"
                ];
            }

            return $msgAndStatus;
        }

        $installation->quotationjob_id = $quotationjob->id;
        $email = explode('-',$request->get('inslead'))[1];
        $installationlead = User::where('email',$email)->first();
        $installation->installationlead_id = $installationlead->id;
        $installation->planned_delivery_date_time = $request->get('planned_delivery_date_time');
        $installation->status = 1;

        try{
            $installation->save();
            $array = [
                "subject_id" =>$installation->id,
                "subject_type" =>"App\\Installation",
                "name" =>"created_installation",
                "key_name" =>$installation->id,
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

        $installationJob = Installation::with(
            'insatllaionlead',
            'job.quotation.inquiry.saleslead.customer',
            'job.quotation.rooms',
            'job.quotation.rooms.walls',
            'job.quotation.rooms.walls.product')
            ->where('id',$installation->id)
            ->first();

        $pdf = SnappyPDF::loadView('pdf.jobcard',array('installation' => $installationJob));
        $pdf->setOrientation('landscape');

        $mailList = [];
        array_push($mailList,$email);
        array_push($mailList,$request->user()->email);

        Mail::to($mailList)
            ->send(new JobCard($pdf));



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

    public function getInstallationLeads(Request $request)
    {
        $query = $request->get('query');
        $results =  User::with('roles')->whereHas('roles',function ($query) {
            $query->where('roles.name','Installation Lead');
        })->select('name','email')->where('name', 'like', "%$query%")->paginate(10);
        $data=[];
        foreach ($results as $result) {
            $val = $result->name . '-' . $result->email;
            array_push($data, $val);
        }
        return $data;
    }

    public function email(){

        //return SnappyPDF::loadFile('http://www.github.com')->inline('github.pdf');

        //dd(public_path());

        $installation = Installation::with(
                                           'insatllaionlead',
                                                    'job.quotation.inquiry.saleslead.customer',
                                                    'job.quotation.rooms',
                                                    'job.quotation.rooms.walls',
                                                    'job.quotation.rooms.walls.product')
                                 ->where('id',1)
                                 ->first();

        //dd($installation);

        //$pdf = new PDF();
        //PDF::setBasePath(realpath(public_path().'/css/bootstrap.css'));
        //$pdf->setBasePath(realpath(public_path().'/css/styles.css'));
        //$pdf = new PDF();

        $pdf = SnappyPDF::loadView('pdf.jobcard',array('installation' => $installation));
        $pdf->setOrientation('landscape');

        //$pdf->getDomPDF()->get_canvas()->page_text(0, 0, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));
        return $pdf->inline();

        //return view('quotations.email',compact(['installation']));
    }

    public function loadEmail(){

        return SnappyPDF::loadFile('http://localhost:8888/wallpaper/public/quotations/email')->inline('github.pdf');
    }



}
