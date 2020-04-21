<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeSetting extends Model
{
    use SoftDeletes;
    protected $table = 'offices_settings';
    protected $fillable = ['office_id', 'clients_number','projects_number','invoices_number','office_vat'];
}
