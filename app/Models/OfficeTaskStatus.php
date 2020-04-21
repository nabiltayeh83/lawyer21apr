<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class  OfficeTaskStatus extends Model
{

    use SoftDeletes;
    protected $table = 'offices_tasks_status';
    protected $fillable = ['office_id','task_status_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function task_status(){
        return $this->BelongsTo('App\Models\TaskStatus', 'task_status_id')->withTrashed();
    }

}

