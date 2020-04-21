<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'consultations';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];
}
