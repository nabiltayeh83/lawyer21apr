<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkgroupTranslation extends Model
{
    use SoftDeletes;
    protected $table='workgroup_translations';
    protected $fillable = ['name','workgroup_id','locale'];
}
