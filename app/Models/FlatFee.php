<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FlatFee extends Model
{

    use SoftDeletes;
    protected $table = 'flats_fees';
    protected $fillable = ['project_id','description','date','price'];

}

