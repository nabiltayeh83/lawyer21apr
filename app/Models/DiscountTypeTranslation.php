<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountTypeTranslation extends Model
{
    use SoftDeletes;
    protected $table='discount_type_translations';
    protected $fillable = ['name','discount_type_id','locale'];
}
