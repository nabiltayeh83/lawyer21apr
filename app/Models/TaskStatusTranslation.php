<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskstatusTranslation extends Model
{
    use SoftDeletes;
    protected $table='task_status_translations';
    protected $fillable = ['name','taskstatus_id','locale'];
}
