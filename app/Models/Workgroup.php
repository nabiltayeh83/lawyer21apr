<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workgroup extends Model
{

    use SoftDeletes, Translatable;
    protected $table = 'workgroups';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];

    public function employees(){
        return $this->hasMany('App\User');
    }

}

