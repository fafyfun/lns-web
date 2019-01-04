<?php

namespace App\Http\Controllers;


use App\Activity;
use Auth;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Activity $act,$subjectId,$subjectType)
    {
        $subjectType = "App\\".$subjectType;
        $activity=$act->with('auth')->where('subject_id',$subjectId)->where('subject_type',$subjectType)->latest()->get();
        //dd($activity);
        $html = "";
        foreach ($activity as $event) {

            if($event->name=='updated_attendance'){

                $html .= "<li class='list-group-item'>" . $event->auth->name . " " . $event->name . " as <b>$event->key_name</b> " . $event->created_at->diffForHumans() . "</li>";

            }else{

                $html .= "<li class='list-group-item'>" . $event->auth->name . " " . $event->name . " " . $event->created_at->diffForHumans() . "</li>";

            }

        }

        return $html;

    }

    public function deleted($subject){

        //dd($subject);

         $class="App\\SubjectRepository\\".$subject;
          $obj=new $class;
          if(is_a($obj, 'App\\SubjectRepository\\Subject')){
              return $obj->deletedActivity();
          }
    }


}
