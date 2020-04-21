<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ReportTask extends Model
{
    use SoftDeletes;
    protected $table = 'reports_tasks';
    protected $fillable = ['report_id','task_id'];

    public function report() {
        return $this->BelongsTo('App\Models\Report', 'report_id')->withTrashed();
    }

    public function task() {
        return $this->BelongsTo('App\Models\Task', 'task_id')->withTrashed();
    }

}
