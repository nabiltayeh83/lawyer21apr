<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class InvoiceInvoiceOutput extends Model
{

    use SoftDeletes;
    protected $table = 'invoices_invoices_outputs';
    protected $fillable = ['invoice_id','invoice_output_id'];

}
