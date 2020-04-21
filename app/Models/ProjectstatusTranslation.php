<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectstatusTranslation extends Model
{
    use SoftDeletes; 
    protected $table='projectstatus_translations';
    protected $fillable = ['name','locale'];
}
