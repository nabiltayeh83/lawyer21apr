<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceHour extends Model
{

    use SoftDeletes;
    protected $table = 'invoices_hours';
    protected $fillable = ['invoice_id', 'hour_id'];

    public function hour() {
        return $this->BelongsTo('App\Models\ProjectHour', 'hour_id')->withTrashed();
    }

}
