<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachtypeTranslation extends Model
{
    use SoftDeletes;
    protected $table='attachtype_translations';
    protected $fillable = ['name','attachtype_id','locale'];
}
