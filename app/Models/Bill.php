<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{

    use SoftDeletes;
    protected $table = 'bills';
    protected $fillable = ['office_id','client_id','invoice_id','payment_date','payment_method_id','reference_number','bank_id','client_account','amount','details'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function client(){
        return $this->BelongsTo('App\Models\Client', 'client_id')->withTrashed();
    }

    public function invoice(){
        return $this->BelongsTo('App\Models\Invoice', 'invoice_id')->withTrashed();
    }

    public function payment_method(){
        return $this->BelongsTo('App\Models\PaymentMethod', 'payment_method_id')->withTrashed();
    }

    public function bank(){
        return $this->BelongsTo('App\Models\Bank', 'bank_id')->withTrashed();
    }

}

