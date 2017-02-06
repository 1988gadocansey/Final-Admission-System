<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class ExcelForm extends Model
{
      //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'forms';
       protected $primaryKey="ID";
    protected $guarded = ['ID'];
    public $timestamps = false;
}
     
     