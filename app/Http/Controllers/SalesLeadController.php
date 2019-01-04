<?php

namespace App\Http\Controllers;

use App\Saleslead;
use Illuminate\Http\Request;

class SalesLeadController extends Controller
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
            "manageLeadActive" =>"active"
        ];

        $leads = Saleslead::with('customer')->paginate(10);
        if($leads->count() > 0){
            $collectionId=$leads->pluck('id');
        }
        return view('leads.show',compact(['leads','collectionId','classItems']));
    }
}
