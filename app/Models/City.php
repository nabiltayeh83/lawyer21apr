<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'cities';
    public $translatedAttributes = ['name'];
    protected $fillable = ['country_id','status'];

    public function country(){
        return $this->BelongsTo('App\Models\Country')->withTrashed();
    }

}
