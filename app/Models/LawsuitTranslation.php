<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LawsuitTranslation extends Model
{
    use SoftDeletes;
    protected $table='lawsuit_translations';
    protected $fillable = ['name','lawsuit_id','locale'];
}
