<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AspectExpense extends Model
{

    use SoftDeletes, Translatable;
    protected $table = 'aspect_expenses';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];
}

