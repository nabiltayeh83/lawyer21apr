<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleTranslation extends Model
{
    use SoftDeletes;
    protected $table='role_translations';
    protected $fillable = ['role_id','locale','name'];
}
