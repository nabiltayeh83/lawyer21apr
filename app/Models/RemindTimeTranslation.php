<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemindTimeTranslation extends Model
{
    use SoftDeletes;
    protected $table='remind_time_translations';
    protected $fillable = ['remind_time_id','locale','name'];
}
