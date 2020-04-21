<?php
namespace App\Models;
use App\User;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'cards';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];
}

