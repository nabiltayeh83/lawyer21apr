<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ReportExpense extends Model
{
    use SoftDeletes;

    protected $table = 'reports_expenses';
    protected $fillable = ['report_id','expense_id'];

    public function report() {
        return $this->BelongsTo('App\Models\Report', 'report_id')->withTrashed();
    }

    public function expense() {
        return $this->BelongsTo('App\Models\Expense', 'expense_id')->withTrashed();
    }


}
