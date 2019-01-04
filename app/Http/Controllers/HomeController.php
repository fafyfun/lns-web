<?php

namespace App\Http\Controllers;


use App\Inquiry;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        if(Gate::denies('VIEW')){
//              abort(403,'Nope');
//        }
        //dd(explode("_",Auth::getName())[1]);
        $dashboardActive='active';
        $agents = User::with('roles')->whereHas('roles',function ($query) {
            $query->whereIn('roles.name',['Sales Executive']);
        })->get();

        $inquiries = Inquiry::with('saleslead','saleslead.customer','agent')
            ->orderBy('created_at', 'desc')
                ->limit(10)->get();

        //dd($inquiries);
        if($inquiries->count() > 0){
            $collectionId=$inquiries->pluck('id');
        }
        return view('home',compact(['dashboardActive','inquiries','collectionId','agents']));
    }
}
