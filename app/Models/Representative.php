<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Representative extends Model
{
    use SoftDeletes;
    protected $table = 'representatives';
    protected $fillable = ['client_id', 'name', 'address', 'email', 'mobile', 'role_name'];
    
    public function role(){
        return $this->BelongsTo('App\Models\Role')->withTrashed();
    }

}
