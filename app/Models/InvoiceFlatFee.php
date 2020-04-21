<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class InvoiceFlatFee extends Model
{

    use SoftDeletes;
    protected $table = 'invoices_flats_fees';
    protected $fillable = ['invoice_id','flat_fee_id'];

    public function flatFee() {
        return $this->BelongsTo('App\Models\FlatFee', 'flat_fee_id')->withTrashed();
    }

}
