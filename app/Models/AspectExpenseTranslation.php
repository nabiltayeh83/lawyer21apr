<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AspectExpenseTranslation extends Model
{
    use SoftDeletes;
    protected $table='aspect_expense_translations';
    protected $fillable = ['name','aspect_expense_id','locale'];
}
