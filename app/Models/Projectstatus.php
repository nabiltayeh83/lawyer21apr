<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projectstatus extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'projectstatuses';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];

}

