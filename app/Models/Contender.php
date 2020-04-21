<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contender extends Model

{

    use SoftDeletes, Translatable;
    protected $table = 'contenders';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status','code'];

}

