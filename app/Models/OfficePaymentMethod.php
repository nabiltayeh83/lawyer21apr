<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficePaymentMethod extends Model
{

    use SoftDeletes;
    protected $table = 'offices_payments_methods';
    protected $fillable = ['office_id','payment_method_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function payment_method(){
        return $this->BelongsTo('App\Models\PaymentMethod', 'payment_method_id')->withTrashed();
    }

}

