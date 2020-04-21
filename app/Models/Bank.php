<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{

    use SoftDeletes;
    protected $table = 'banks';
    protected $fillable = ['office_id','name','iban','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function payment_method(){
        return $this->BelongsTo('App\Models\PaymentMethod', 'payment_method_id')->withTrashed();
    }

}

