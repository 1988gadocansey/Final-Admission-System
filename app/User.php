<?php

namespace App;

 
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
     protected $table = 'tpoly_forms';
       protected $primaryKey="ID"; 
     protected $guarded = ['ID'];
      public $timestamps = false;
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'SERIAL', 'remember_token','PIN'
    ];

    /**
     * Get all of the tasks for the user.
     */
   public function applicants(){
        return $this->hasMany('App\Models\ApplicantModel', "FORM_NO","APPLICATION_NUMBER");
    }
}
