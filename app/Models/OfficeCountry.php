<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeCountry extends Model
{

    use SoftDeletes;
    protected $table = 'offices_countries';
    protected $fillable = ['office_id','country_id','status'];

    public function office(){
        return $this->BelongsTo('App\User', 'office_id')->withTrashed();
    }

    public function country(){
        return $this->BelongsTo('App\Models\Country', 'country_id')->withTrashed();
    }

}

