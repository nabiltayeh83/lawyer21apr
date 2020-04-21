<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeInvoiceOutput extends Model
{

    use SoftDeletes;
    protected $table = 'offices_invoices_outputs';
    protected $fillable = ['office_id','invoice_output_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function invoice_output(){
        return $this->BelongsTo('App\Models\InvoiceOutput', 'invoice_output_id')->withTrashed();
    }

}

