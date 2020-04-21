<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleGroup extends Model
{

    use SoftDeletes;
    protected $table = 'roles_groups';
    protected $fillable = ['office_id', 'name', 'status'];

}

