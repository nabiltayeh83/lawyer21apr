<?php
namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lawsuit extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'lawsuits';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];
}
