<?php
namespace App\Models;
use App\User;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectHour extends Model
{

    use SoftDeletes;
    protected $table = 'projects_hours';
    protected $fillable = ['project_id', 'client_id', 'responsible_lawyer', 'hours_count', 'price', 'start_date', 'hour_status', 'hour_details', 'hour_office_details'];

     public function task(){
        return $this->BelongsTo('App\Models\Task', 'task_id')->withTrashed();
    }

    public function employee(){
        return $this->BelongsTo('App\User', 'responsible_lawyer')->withTrashed();
    }

    public function project() {
        return $this->BelongsTo('App\Models\Project', 'project_id')->withTrashed();
    }

}

