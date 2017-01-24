<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class ApplicantModel extends Model
{
    use LogsActivity;
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpoly_applicants';
     protected static $logAttributes = ['APPLICATION_NUMBER', 'SURNAME','PHONE','FIRST_CHOICE','SECOND_CHOICE','THIRD_CHOICE'];
    protected $primaryKey="ID";
    protected $guarded = ['ID'];
    public $timestamps = false;
    public function programme(){
        return $this->hasMany('App\Models\ProgrammeModel', "FIRST_CHOICE","PROGRAMMECODE");
    }
    public function program(){
        return $this->belongsTo('App\Models\ProgrammeModel', "PROGRAMMECODE","FIRST_CHOICE");
    }
    public function formDetails(){
        return $this->belongsTo('App\Models\FormModel', "APPLICATION_NUMBER","FORM_NO");
    }
     
}
