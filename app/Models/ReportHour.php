<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ReportHour extends Model
{
    use SoftDeletes;
 
    protected $table = 'reports_hours';
    protected $fillable = ['report_id','hour_id'];
    protected $with = ['hour'];

    public function report() {
        return $this->BelongsTo('App\Models\Report', 'report_id')->withTrashed();
    }

    public function hour() {
        return $this->BelongsTo('App\Models\ProjectHour', 'hour_id')->withTrashed();
    }

}
