<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardTranslation extends Model
{
    use SoftDeletes;
    protected $table='card_translations';
    protected $fillable = ['name','card_id','locale'];
}
