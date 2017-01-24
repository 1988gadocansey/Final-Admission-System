<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class GradeSystemModel extends Model
{
     use LogsActivity;
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_waec_grades_system';
    protected $primaryKey="id";
    protected $guarded = ['id'];
    public $timestamps = false;
    
     
}
