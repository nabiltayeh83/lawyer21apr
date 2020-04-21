<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

use Carbon\Carbon;

class Project extends Model
{

    use SoftDeletes;
    protected $fillable = ['office_id','type','client_id','name','client_description_id','contender_id','contender_name','contender_address','case_name','fee_type','value_per_hour','issue_fees','project_number','reference_number','details','lawsuit_id','project_status_id','start_project_date','gov_institution','consultation_id','responsible_lawyer','workgroup_id'];
    protected $with = ["project_status", "reports", "extra_fields"];
    
    public function extra_fields()
    {
        return $this->hasMany('App\Models\ProjectField');
    }

    public function project_status() {
        return $this->BelongsTo('App\Models\Projectstatus')->withTrashed();
    }

    public function attachments(){
        return $this->morphMany('App\Models\Attachment', 'attachmentable');
    }

    public function client(){
        return $this->BelongsTo('App\Models\Client')->withTrashed();
    }

    public function lawsuit(){
        return $this->BelongsTo('App\Models\Lawsuit')->withTrashed();
    }

    public function status(){
        return $this->BelongsTo('App\Models\Projectstatus', 'project_status_id')->withTrashed();
    }

    public function project_manager(){
        return $this->BelongsTo('App\User', 'responsible_lawyer')->withTrashed();
    }

    public function hours()
    {
        return $this->hasMany('App\Models\ProjectHour', 'project_id')->orderBy('start_date');
    }

    public function bills(){
        return $this->hasMany('App\Models\Bill');
    }

    public function invoices(){
        return $this->hasMany('App\Models\Invoice');
    }
    
    public function reports(){
        return $this->hasMany('App\Models\Report', 'project_id');
    }

    public function flats_fees()
    {
        return $this->hasMany('App\Models\FlatFee', 'project_id')->orderBy('date');
    }


    public function activities()
    {
        return $this->hasMany('App\Models\ActivityProject', 'project_id')->orderBy('id', 'desc');
    }

    public function expenses()
    {
        return $this->hasMany('App\Models\Expense', 'project_id')->orderBy('expense_date', 'asc');
    }


    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'project_id');
    }

    public function project_notes(){
        return $this->morphMany('App\Models\Note', 'noteable')->orderBy('note_date', 'asc');
    }


    public function employees(){
        return $this->hasMany('App\Models\ProjectEmployee');
    }


}
