<?php
namespace App\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemindTime extends Model
{

    use SoftDeletes, Translatable;
    protected $table = 'reminds_times';
    public $translatedAttributes = ['name'];

}
