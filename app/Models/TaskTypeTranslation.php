<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskTypeTranslation extends Model
{
    use SoftDeletes;
    protected $table='task_type_translations';
    protected $fillable = ['name','task_type_id','locale'];
}
