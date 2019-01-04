<?php

namespace App\Http\Controllers;

use App\ActivityRepository\NormalActivity;
use App\Salestarget;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesTargetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {

        $collectionId = [];

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "salesTargetActive" =>"active",
            "salesTargetIn" =>"in",
            "manageSalesTargetActive" =>"active"
        ];


        $salestargets = Salestarget::with('agent')
                        ->paginate(120);
        //dd($salestargets->pluck('id'));
//        $a = $salestargets->groupBy(['agent_id','year']);
//        dd($a);
//        $agentGroups = $salestargets->groupBy('agent_id');
//
//        $outerArray=[];
//
//        foreach ($agentGroups as $key1 => $agentGroup ){
//
//            foreach($agentGroup->groupBy('year') as $key2 => $val){
//                //dd($val);
//                $innerArray=[];
//                array_push($innerArray,$agentGroup[0]->agent->name);
//                array_push($innerArray,$key2);
//                  foreach ($val as $v){
//
//                      array_push($innerArray,$v->target);
//
//                  }
//                array_push($outerArray,$innerArray);
//
//            }
//
//        }
//
//        dd($outerArray);



        // dd($roles->toArray()['data']);

        if($salestargets->count() > 0){

            $collectionId=$salestargets->pluck('id');

        }

        $agents = User::with('roles')->whereHas('roles',function ($query) {
            $query->whereIn('roles.name',['Sales Executive']);
        })->get();

        //$collectionId = collect($allId);
        return view('salestargets.show',compact(['agents','salestargets','collectionId','classItems']));
    }

    public function create()
    {

        $classItems=[
            "masterDataActive"=>"active",
            "masterIn" =>"in",
            "userDataActive"=>"active",
            "userDataIn" =>"in",
            "salesTargetActive" =>"active",
            "salesTargetIn" =>"in",
            "createSalesTargetActive" =>"active"
        ];

        return view('salestargets.create',compact(['classItems']));
    }

    public function store(Request $request,NormalActivity $normalActivity)
    {
        //dd($request->get('target'));
//        $validator = Validator::make($request->all(), [
//            'agent' => 'required',
//            'year' => 'required',
//            'target' => 'target_array:1',
//        ]);
//dd($validator->errors()->messages());
        $this->validate($request, [
            'agent' => 'required',
            'year' => 'required|date_format:"Y"',
            'target' => 'target_array:1'
        ]);

        //dd($request->get('target'));

        $msgAndStatus = [
            "error" => "Not Inserted"
        ];

        $email = explode('-',$request->get('agent'))[1];
        $agent = User::where('email',$email)->first();
        //$month =4;



        foreach ($request->get('target') as $key => $t){

            DB::beginTransaction();

            $salestarget = new Salestarget;
            $salestarget->agent_id = $agent->id;
            $salestarget->year = $request->get('year');
            $salestarget->month = $key;
            $salestarget->target = $t;

            if($salestarget->isDirty()){

                $msgAndStatus = [
                    "success" => "Inserted"
                ];
            }

            try{
                $salestarget->save();
                $sujectMatters=$this->setAndGetSubjectMatters($salestarget->id,"created_salestarget",$salestarget->id);
                $normalActivity->updateActivity($sujectMatters);
            }catch(\Illuminate\Database\QueryException $e){

                    DB::rollBack();
                $error_code = $e->errorInfo[1];
                if ($error_code) {
                    $msgAndStatus = [
                        "error" => $e->errorInfo[2]
                    ];
                }
                return  back()->with($msgAndStatus)->withInput();
            }
//            if( $month == 12){
//                $month=0;
//            }
//
//            $month++;

            DB::commit();

        }



        return  back()->with($msgAndStatus);



        //dd($request->get('target'));


    }

    public function edit($agentId,$year){

        $salestarget = Salestarget::with('agent')
                    ->where('agent_id',$agentId)
                    ->where('year',$year)
                    ->orderBy('id','asc')
                    ->get();
        //dd($salestarget[0]);

        return view('salestargets.edit',compact(['salestarget']));
    }

    public function update(Request $request,NormalActivity $normalActivity,$agentId,$year){

        $this->validate($request, [
            'agent' => 'required',
            'year' => 'required|date_format:"Y"',
            'target' => 'target_array:1'
        ]);

        $msgAndStatus = [
            "error" => "Not Updated"
        ];

        $email = explode('-',$request->get('agent'))[1];
        $agent = User::where('email',$email)->first();

        foreach ($request->get('target') as $key => $t){

            DB::beginTransaction();

            $salestarget = new Salestarget;
            $salestarget = $salestarget->where('agent_id',$agentId)
                            ->where('year',$year)
                            ->where('month',$key)
                            ->first();
            //dd($salestarget);
            $salestarget->agent_id = $agent->id;
            $salestarget->year = $request->get('year');
            $salestarget->month = $key;
            $salestarget->target = $t;

            if($salestarget->isDirty()){

                $msgAndStatus = [
                    "success" => "Updated"
                ];
            }

            try{
                $salestarget->save();
                $sujectMatters=$this->setAndGetSubjectMatters($salestarget->id,"updated_salestarget",$salestarget->id);
                $normalActivity->updateActivity($sujectMatters);
            }catch(\Illuminate\Database\QueryException $e){

                DB::rollBack();
                $error_code = $e->errorInfo[1];
                if ($error_code) {
                    $msgAndStatus = [
                        "error" => $e->errorInfo[2]
                    ];
                }
                return  back()->with($msgAndStatus)->withInput();
            }
//            if( $month == 12){
//                $month=0;
//            }
//
//            $month++;

            DB::commit();

        }
        return redirect("salestarget")->with($msgAndStatus);


    }

    public function setAndGetSubjectMatters($subject_id,$name,$key_name){
        $sujectMatters=array(
            "subject_id" => $subject_id,
            "name" => $name,
            "key_name" => $key_name
        );
        return $sujectMatters;
    }
}
