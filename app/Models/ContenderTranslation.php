<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContenderTranslation extends Model
{
    use SoftDeletes;
    protected $table='contender_translations';
    protected $fillable = ['name','contender_id','locale'];
}
