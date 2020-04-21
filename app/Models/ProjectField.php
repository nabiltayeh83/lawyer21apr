<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Carbon\Carbon;

class ProjectField extends Model
{
    use SoftDeletes;
    protected $table = 'projects_fields';
    protected $fillable = ['project_id','field_id','value'];
    protected $with = ["field"];
    
    public function field(){
        return $this->BelongsTo('App\Models\Field', 'field_id', 'id')->withTrashed();
    }
    
}
