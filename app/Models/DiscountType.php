<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountType extends Model
{

    use SoftDeletes, Translatable;
    protected $table = 'discounts_types';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];

}

