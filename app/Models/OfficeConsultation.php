<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeConsultation extends Model
{

    use SoftDeletes;
    protected $table = 'offices_consultations';
    protected $fillable = ['office_id','consultation_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function consultation(){
        return $this->BelongsTo('App\Models\Consultation', 'consultation_id')->withTrashed();
    }

}

