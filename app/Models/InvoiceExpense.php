<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceExpense extends Model
{
    
    use SoftDeletes;
    protected $table = 'invoices_expenses';
    protected $fillable = ['invoice_id', 'expense_id'];

    public function expense(){
        return $this->BelongsTo('App\Models\Expense', 'expense_id')->withTrashed();
    }

}
