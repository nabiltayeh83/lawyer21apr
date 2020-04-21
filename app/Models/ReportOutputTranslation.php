<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportOutputTranslation extends Model
{
    use SoftDeletes;
    protected $table='report_output_translations';
    protected $fillable = ['report_output_id','locale','name'];
}
