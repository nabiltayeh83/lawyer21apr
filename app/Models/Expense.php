<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Expense extends Model
{

    use SoftDeletes;
    protected $table = 'expenses';
    protected $fillable = ['office_id','related_project','project_id','aspect_expense_id','reference_number','expense_date','total_amount','expense_details','expense_office_details','responsible_lawyer','expense_status'];

    public function attachments(){
        return $this->morphMany('App\Models\Attachment', 'attachmentable');
    }

    public function employee(){
        return $this->BelongsTo('App\User', 'responsible_lawyer')->withTrashed();
    }

    public function project() {
        return $this->BelongsTo('App\Models\Project', 'project_id')->withTrashed();
    }

    public function aspect_expense() {
        return $this->BelongsTo('App\Models\AspectExpense', 'aspect_expense_id')->withTrashed();
    }

}
