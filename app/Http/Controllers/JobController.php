<?php

namespace App\Http\Controllers;

use App\Quotationjob;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $classItems=[
            "jobActive" => "active",
            "jobIn" => "in",
            "manageJobActive" =>"active",
        ];

        $jobs = Quotationjob::with('installation')->paginate(10);

        if($jobs->count() > 0){
            $collectionId=$jobs->pluck('id');
        }

        //dd($jobs);

        return view('jobs.show',compact(['jobs','collectionId','classItems']));
    }
}
