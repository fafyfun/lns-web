<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword as ResetPasswordNotification;


class User extends Authenticatable
{
    use Notifiable;
    //use RecordsActivity;

    protected static $recordEvents = ['created','updated'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','phone_number', 'email', 'password','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The roles that belong to the user.
     * many-to-many
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role','role_user','user_id','role_id')->withPivot('id')->withTimestamps();
    }

    /**
     * Get the activity timeline for the user.
     *
     * @return mixed
     */
    public function activities()
    {
        return $this->hasMany('App\Activity');

    }
    /**
     * Record new activity for the user.
     *
     * @param  string $name
     * @param  mixed  $related
     * @throws \Exception
     * @return void
     */
    public function recordActivity1($name, $related)
    {
        if (! method_exists($related, 'recordActivity')) {
            throw new \Exception('..');
        }
        return $related->recordActivity($name);
    }

    public function hasRole($role){

        if(is_string($role)){

            return $this->roles->contains('name',$role);
        }

        return !! $role->intersect($this->roles)->count();

    }

    /**
     * Get the inquiries for the agent.
     * one-to-many
     */

    public function agentInquiries()
    {
        return $this->hasMany('App\Inquiry','agent_id');
    }

    /**
     * Get the inquiries created by the user.
     * one-to-many
     */

    public function createdInquiries()
    {
        return $this->hasMany('App\Inquiry','created_by');
    }

    /**
     * Get the salestargets for the agent.
     * one-to-many
     */

    public function agentSalesTargets()
    {
        return $this->hasMany('App\Salestarget','agent_id');
    }

    public function installaions()
    {
        return $this->hasMany('App\Installation','insatllationlead_id');
    }

//    /**
//     * The faculties that belong to the user.
//     * many-to-many
//     */
//    public function faculties()
//    {
//        return $this->belongsToMany('App\Faculty','faculty_user','user_id','faculty_id')->withPivot('id')->withTimestamps();
//    }
//
//    /**
//     * The courses that belong to the user.
//     * many-to-many
//     */
//    public function courses()
//    {
//        return $this->belongsToMany('App\Course','course_user','user_id','course_id')->withPivot('id')->withTimestamps();
//    }
//
//    /**
//     * The departments that belong to the user.
//     * many-to-many
//     */
//    public function departments()
//    {
//        return $this->belongsToMany('App\Department','department_user','user_id','department_id')->withPivot('id')->withTimestamps();
//    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


}
