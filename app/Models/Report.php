<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Report extends Model
{
    use SoftDeletes;

    protected $table = 'reports';
    protected $fillable = ['office_id','project_id','task_id','report_content','report_office_content','next_date','appendix','status'];
    protected $appends = ['report_outputs'];


    public function getReportOutputsAttribute()
    {
        return ReportReportOutput::where('report_id', $this->id)->pluck('report_output_id')->toArray();
    }
    

    public function project() {
        return $this->BelongsTo('App\Models\Project', 'project_id')->withTrashed();
    }
    
    public function task() {
        return $this->BelongsTo('App\Models\Task', 'task_id')->withTrashed();
    }


    public function attachments(){
        return $this->morphMany('App\Models\Attachment', 'attachmentable');
    }
    
    public function reportExpenses()
    {
        return $this->hasMany('App\Models\ReportExpense', 'report_id');
    }

    public function reportHours()
    {
        return $this->hasMany('App\Models\ReportHour', 'report_id');
    }

    public function reportTasks()
    {
        return $this->hasMany('App\Models\ReportTask', 'report_id');
    }

}
