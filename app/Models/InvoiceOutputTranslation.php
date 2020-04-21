<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceOutputTranslation extends Model
{
    use SoftDeletes;
    protected $table='invoice_output_translations';
    protected $fillable = ['name','invoice_output_id','locale'];
}
