<?php

namespace App\Http\Controllers;

use App\Installation;
use Illuminate\Http\Request;

class InstallationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view($id){

        $installation = Installation::with(
            'insatllaionlead',
            'job.quotation.inquiry.saleslead.customer',
            'job.quotation.rooms',
            'job.quotation.rooms.walls',
            'job.quotation.rooms.walls.product')
            ->where('id',$id)
            ->first();

        //dd($installation);

        return view('installations.view',compact(['installation']));
    }
}
