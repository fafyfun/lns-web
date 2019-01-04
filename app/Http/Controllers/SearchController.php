<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function search(Request $request,$subject)
    {

        $class="App\\SubjectRepository\\".$subject;
        $obj=new $class;
        if(is_a($obj, 'App\\SubjectRepository\\Subject')){
            return $obj->search($request);
        }
    }
}
