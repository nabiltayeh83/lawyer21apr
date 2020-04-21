<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ActivityProject extends Model
{
    use SoftDeletes;
    protected $table = 'activities_projects';
    protected $fillable = ['office_id', 'action_user_id', 'activity_id', 'project_id'];

    public function user(){
        return $this->BelongsTo('App\User', 'action_user_id')->withTrashed();
    }

    public function activity(){
        return $this->BelongsTo('App\Models\Activity', 'activity_id')->withTrashed();
    }

    public function project(){
        return $this->BelongsTo('App\Models\Project', 'project_id')->withTrashed();
    }

}
