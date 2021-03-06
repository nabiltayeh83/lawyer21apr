<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientDescription extends Model
{

    use SoftDeletes, Translatable;
    protected $table = 'clients_descriptions';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];

}

