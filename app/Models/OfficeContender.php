<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeContender extends Model
{

    use SoftDeletes;
    protected $table = 'offices_contenders';
    protected $fillable = ['office_id','contender_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function contender(){
        return $this->BelongsTo('App\Models\Contender', 'contender_id')->withTrashed();
    }

}

