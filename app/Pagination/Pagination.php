<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 10/22/2016
 * Time: 10:12 PM
 */
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination
{
    public function __construct()
    {
        //$this->middleware('auth');

    }
    public function paginate($items,$totalcount,$perPage,$pageStart,$offSet)
    {
        // Get only the items you need using array_slice
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage, true);

        return new LengthAwarePaginator($itemsForCurrentPage, $totalcount, $perPage,Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
    }
}