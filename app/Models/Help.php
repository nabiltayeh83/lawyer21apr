<?php
namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Help extends Model
{

    use SoftDeletes, Translatable;
    protected $table = 'helps';
    public $translatedAttributes = ['question', 'answer'];

}
