<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Event extends Model
{

    use SoftDeletes;
    protected $table = 'events';
    protected $fillable = ['office_id','title','type','start_date','start_time','end_date','end_time','details'];

}
