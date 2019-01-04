<?php
/**
 * Created by PhpStorm.
 * User: mulaffer
 * Date: 11/20/16
 * Time: 7:45 PM
 */

namespace App\SubjectRepository;
use Illuminate\Http\Request;


interface Subject
{
    public function deletedActivity();

    public function search(Request $request);


}