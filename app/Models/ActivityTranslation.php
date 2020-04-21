<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityTranslation extends Model
{
    use SoftDeletes;
    protected $table='activity_translations';
    protected $fillable = ['activity_id','locale','name'];
}
