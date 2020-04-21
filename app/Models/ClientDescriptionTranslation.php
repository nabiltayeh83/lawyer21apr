<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientDescriptionTranslation extends Model
{
    use SoftDeletes;
    protected $table='client_description_translations';
    protected $fillable = ['name','client_description_id','locale'];
}
