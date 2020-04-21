<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Carbon\Carbon;

class Zone extends Model
{
    use SoftDeletes;
    protected $table = 'zones';
    protected $fillable = ['name'];
}
