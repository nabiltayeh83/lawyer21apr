<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeLawsuit extends Model
{

    use SoftDeletes;
    protected $table = 'offices_lawsuits';
    protected $fillable = ['office_id','lawsuit_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function lawsuit(){
        return $this->BelongsTo('App\Models\Lawsuit', 'lawsuit_id')->withTrashed();
    }

}

