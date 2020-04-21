<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Task extends Model
{
 
    use SoftDeletes;
    protected $fillable = ['office_id','name','task_category_id','task_type_id','details','taskstatus_id','priority','start_date','end_date','workgroup_id','remind','remind_type','remind_time'];

    public function category() {
        return $this->BelongsTo('App\Models\TaskCategory', 'task_category_id')->withTrashed();
    }

    public function employees(){
        return $this->hasMany('App\Models\TaskEmployee');
    }

    public function project() {
        return $this->BelongsTo('App\Models\Project', 'project_id')->withTrashed();
    }

    public function employee(){
        return $this->BelongsTo('App\User', 'responsible_employee')->withTrashed();
    }

    public function task_status(){
        return $this->BelongsTo('App\Models\TaskStatus', 'task_status_id')->withTrashed();
    }

    public function remind_time(){
        return $this->BelongsTo('App\Models\RemindTime', 'remind_time_id')->withTrashed();
    }

    public function task_type() {
        return $this->BelongsTo('App\Models\TaskType', 'task_type_id')->withTrashed();
    }

    public function attachments(){
        return $this->morphMany('App\Models\Attachment', 'attachmentable');
    }

    public function hours()
    {
        return $this->hasMany('App\Models\ProjectHour', 'task_id')->orderBy('start_date', 'asc');
    }
    
    
    public function reports()
    {
        return $this->hasMany('App\Models\Report', 'task_id');
    }

}
