<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReportReportOutput extends Model
{
    
    use SoftDeletes;
    protected $table = 'reports_reports_outputs';
    protected $fillable = ['report_id','report_output_id'];

}
