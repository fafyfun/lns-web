<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    //protected $table = 'activities';

    protected $fillable = [
        'subject_id', 'subject_type','name','key_name','auth_id','auth_type'
    ];
    /**
     * Get the user responsible for the given activity.
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the user responsible for the given activity.
     *
     * @return User
     */
    public function owner()
    {
        return $this->belongsTo('App\Owner');
    }
    /**
     * Get the subject of the activity.
     *
     * @return mixed
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Get the subject of the activity.
     *
     * @return mixed
     */
    public function auth()
    {
        return $this->morphTo();
    }
}
