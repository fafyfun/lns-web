<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class Role extends Model
{
    //use SoftDeletes;
    use RecordsActivity;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    //protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'shortname','description',
    ];

    /**
     * The users that belong to the role.
     * many-to-many
     */
    public function users()
    {
        return $this->belongsToMany('App\User','role_user', 'role_id', 'user_id')->withPivot('id')->withTimestamps();
    }

    /**
     * The users that belong to the role.
     * many-to-many
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission','permission_role', 'role_id', 'permission_id')->withPivot('id')->withTimestamps();
    }

    /**
     * The passengers that belong to the role.
     * many-to-many
     */
    public function passengers()
    {
        return $this->belongsToMany('App\Passenger','passenger_role', 'role_id', 'passenger_id')->withPivot('id')->withTimestamps();
    }



}
