<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{

    use SoftDeletes, Translatable;
    protected $table = 'countries';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status','code'];

    public function cities(){
        return $this->hasMany('App\Models\City');
    }

}

