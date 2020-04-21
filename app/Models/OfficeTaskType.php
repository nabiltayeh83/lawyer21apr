<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeTaskType extends Model
{

    use SoftDeletes;
    protected $table = 'offices_tasks_types';
    protected $fillable = ['office_id','task_type_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function task_type(){
        return $this->BelongsTo('App\Models\TaskType', 'task_type_id')->withTrashed();
    }

}

