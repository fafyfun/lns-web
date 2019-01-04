<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class RoleUser extends Model
{
    //use SoftDeletes;
    protected  $table='role_user';

    public function getUserAssignedRole($perPage,$search = null)
    {

        //DB::enableQueryLog();



        $result = DB::table($this->table)
            ->join('roles', $this->table . '.role_id', '=', 'roles.id')
            ->join('users', $this->table . '.user_id', '=', 'users.id')
            ->select($this->table.'.id',DB::raw("CONCAT(role_id,',',user_id) AS roleuser_id"),'users.id AS user_id'
                ,'users.name As user_name', 'users.email', 'roles.id AS role_id'
                , 'roles.name AS role_name', 'roles.shortname');

        if($search){
            $result->where(function($query) use($search){
                $query->where('users.name','like',"%$search%")
                    ->orWhere('users.email','like',"%$search%")
                    ->orWhere('roles.name','like',"%$search%")
                    ->orWhere('roles.shortname','like',"%$search%");
            });

        }

        $result=$result->orderBy($this->table.'.created_at','desc')
                        ->paginate($perPage);
        //dd(DB::getQueryLog());

        return $result;

    }


}
