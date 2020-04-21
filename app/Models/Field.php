<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Carbon\Carbon;

class Field extends Model
{
    use SoftDeletes;
    protected $table = 'fields';
    protected $fillable = ['office_id','type','name','required','apply_to'];
}
