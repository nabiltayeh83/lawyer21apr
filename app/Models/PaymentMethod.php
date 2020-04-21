<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes, Translatable;
    
    protected $table = 'payments_methods';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];

}

