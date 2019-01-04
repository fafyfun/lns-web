<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use RecordsActivity;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'shortname','description',
    ];

    /**
     * The roles that belong to the permissions.
     * many-to-many
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role','permission_role', 'permission_id', 'role_id')->withPivot('id')->withTimestamps();
    }


}
