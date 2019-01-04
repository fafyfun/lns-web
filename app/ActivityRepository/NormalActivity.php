<?php

namespace App\ActivityRepository;
use App\Activity;

class NormalActivity
{
    public function updateActivity($subjectMatters) {


        Activity::where('subject_id',$subjectMatters['subject_id'])
                      ->where('name',$subjectMatters['name'])
                      ->update(['key_name'=> $subjectMatters['key_name']]);

    }

    public function createActivity(array $array) {

        Activity::create($array);

    }





}