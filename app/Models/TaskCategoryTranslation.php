<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskCategoryTranslation extends Model
{
    use SoftDeletes;
    protected $table='task_category_translations';
    protected $fillable = ['name','task_category_id','locale'];
}
