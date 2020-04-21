<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskStatus extends Model
{
    use SoftDeletes, Translatable;
    protected $table = 'tasks_status';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];
}

