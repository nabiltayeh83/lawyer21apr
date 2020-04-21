<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleGroupDepartment extends Model
{

    use SoftDeletes;
    protected $table = 'roles_groups_departments';
    protected $fillable = ['role_group_id','department_id'];
    
    // public function role_group()
    // {
    //     return $this->belongsTo(RoleGroup::class, 'role_group_id')->withTrashed();
    // }
    
    
    // public function department()
    // {
    //     return $this->belongsTo(Department::class, 'department_id')->withTrashed();
    // }

}
