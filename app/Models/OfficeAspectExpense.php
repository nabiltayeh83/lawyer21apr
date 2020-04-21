<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeAspectExpense extends Model
{

    use SoftDeletes;
    protected $table = 'offices_aspect_expenses';
    protected $fillable = ['office_id','aspect_expense_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function aspect_expense(){
        return $this->BelongsTo('App\Models\AspectExpense', 'aspect_expense_id')->withTrashed();
    }

}

