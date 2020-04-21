<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Client extends Model
{

    use SoftDeletes;

    protected $fillable = ['office_id', 'type', 'name', 'client_number', 'gender', 'ID_number', 'card_id', 'commercial_license', 'country_id','city_id','address', 'phone', 'mobile', 'email', 'notes', 'status'];
    protected $table = 'clients';
    protected $with = ["city", "country", "card", "attachments", "client_notes"];

    public function city(){
        return $this->BelongsTo('App\Models\City')->withTrashed();
    }

    public function country(){
        return $this->BelongsTo('App\Models\Country')->withTrashed();
    }

    public function card(){
        return $this->BelongsTo('App\Models\Card')->withTrashed();
    }

    public function representatives(){
        return $this->hasMany('App\Models\Representative');
    }

    public function bills(){
        return $this->hasMany('App\Models\Bill');
    }

    public function invoices(){
        return $this->hasMany('App\Models\Invoice');
    }

    public function hours(){
        return $this->hasMany('App\Models\ProjectHour');
    }

    public function attachments(){
        return $this->morphMany('App\Models\Attachment', 'attachmentable');
    }

    public function client_notes(){
        return $this->morphMany('App\Models\Note', 'noteable')->orderBy('note_date', 'asc');
    }

    public function projects(){
        return $this->hasMany('App\Models\Project')->orderBy('id', 'desc');
    }

}
