<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

use DB;

class PermissionRole extends Model
{
    //use SoftDeletes;
    protected $table = 'permission_role';


    public function getAssignedPermission($perPage,$search = null)
    {

        //DB::enableQueryLog();



        $result = DB::table($this->table)
            ->join('permissions', $this->table . '.permission_id', '=', 'permissions.id')
            ->join('roles', $this->table . '.role_id', '=', 'roles.id')
            ->select($this->table.'.id',DB::raw("CONCAT(permission_id,',',role_id) AS permissionrole_id"),'permissions.id AS permission_id'
                ,'permissions.name As permission_name', 'roles.id AS role_id'
                , 'roles.name AS role_name', 'roles.shortname');

        if($search){
            $result->where(function($query) use($search){
                $query->where('permissions.name','like',"%$search%")
                    ->orWhere('roles.name','like',"%$search%");
            });

        }

        $result=$result->orderBy($this->table.'.created_at','desc')
            ->paginate($perPage);
        //dd(DB::getQueryLog());




        return $result;

    }
}
