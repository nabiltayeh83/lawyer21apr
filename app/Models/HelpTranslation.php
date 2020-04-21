<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HelpTranslation extends Model
{
    use SoftDeletes;
    protected $table='help_translations';
    protected $fillable = ['help_id','locale','question','answer'];
}
