<?php
namespace App\Models;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceOutput extends Model
{

    use SoftDeletes, Translatable;
    protected $table = 'invoices_outputs';
    public $translatedAttributes = ['name'];
    protected $fillable = ['status'];

}

