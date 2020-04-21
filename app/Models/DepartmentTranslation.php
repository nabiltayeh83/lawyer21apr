<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepartmentTranslation extends Model
{
    use SoftDeletes;
    protected $table= 'department_translations';
    protected $fillable = ['name','department_id','locale'];
}
