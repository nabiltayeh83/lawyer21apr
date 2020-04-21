<?php
namespace App\Models;
use App\User;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Department extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'departments';
    public $translatedAttributes = ['name'];
}

