<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeDiscountType extends Model
{

    use SoftDeletes;
    protected $table = 'offices_discounts_types';
    protected $fillable = ['office_id','discount_type_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function discount_type(){
        return $this->BelongsTo('App\Models\DiscountType', 'discount_type_id')->withTrashed();
    }

}

