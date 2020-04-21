<?php
namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectEmployee extends Model
{
    use SoftDeletes;
    protected $table = 'project_employees';
    protected $fillable = ['project_id', 'user_id'];
    protected $with = ['user'];

    public function user(){
        return $this->BelongsTo('App\User', 'user_id', 'id')->withTrashed();
    }

}


