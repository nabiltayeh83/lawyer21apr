<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskCategory extends Model
{
    
    use SoftDeletes, Translatable;
    protected $table = 'tasks_categories';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];

}

