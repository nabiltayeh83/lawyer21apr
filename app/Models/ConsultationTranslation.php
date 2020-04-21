<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsultationTranslation extends Model
{
    use SoftDeletes;
    protected $table='consultation_translations';
    protected $fillable = ['name','consultation_id','locale'];
}
