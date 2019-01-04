<?php
/**
 * Created by PhpStorm.
 * User: mulaffer
 * Date: 12/3/16
 * Time: 2:07 PM
 */

namespace App\ActivityRepository;

use App\MToMActivity;


class ManyToManyActivity
{
    public function create(array $array){

        MToMActivity::create($array);

    }
}