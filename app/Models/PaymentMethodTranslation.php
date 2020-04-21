<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethodTranslation extends Model
{
    use SoftDeletes;
    protected $table='payment_method_translations';
    protected $fillable = ['name','payment_method_id','locale'];
}
