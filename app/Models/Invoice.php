<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Invoice extends Model
{

    use SoftDeletes;
    protected $table = 'invoices';
    protected $fillable = ['client_id','project_id','invoice_number','vat_status','release_date','claim_date','office_address','client_address','final_total','discount_status','discount_name','discount_type','discount_amount','invoice_approval','invoice_output_id','status'];
    protected $with = ['project'];
    protected $appends = ['invoice_amount', 'invoice_bills','invoice_outputs'];
    
    
    public function getInvoiceOutputsAttribute()
    {
        return InvoiceInvoiceOutput::where('invoice_id', $this->id)->pluck('invoice_output_id')->toArray();
    }
    
    
    public function getInvoiceAmountAttribute(){
   
        $invoice_discount = 0;
        $vat_amount = 0;
        
        if($this->discount_status == 'yes' && $this->discount_type_id == 1 && $this->discount_amount >= 1){
            $invoice_discount = ($this->final_total*$this->discount_amount) / 100;
        }
        
        if($this->discount_status == 'yes' && $this->discount_type_id == 2 && $this->discount_amount >= 1){
            $invoice_discount = $this->discount_amount;
        }
        
        $final_total = $this->final_total - $invoice_discount;
        
        if($this->vat_status == 'yes' && $this->vat >= 1){
            $vat_amount = ($final_total*$this->vat) / 100;
        }
        
        return $final_total + $vat_amount;
    }
    
    
    public function getInvoiceBillsAttribute(){
        return $this->hasMany('App\Models\Bill', 'invoice_id')->sum('amount');
    }
    

    public function attachments(){
        return $this->morphMany('App\Models\Attachment', 'attachmentable');
    }

    public function client(){
        return $this->BelongsTo('App\Models\Client', 'client_id')->withTrashed();
    }

    public function project() {
        return $this->BelongsTo('App\Models\Project', 'project_id')->withTrashed();
    }

    public function invoiceExpenses()
    {
        return $this->hasMany('App\Models\InvoiceExpense', 'invoice_id');
    }

    public function invoiceFlatsFees()
    {
        return $this->hasMany('App\Models\InvoiceFlatFee', 'invoice_id');
    }

    public function invoiceHours()
    {
        return $this->hasMany('App\Models\InvoiceHour', 'invoice_id');
    }

    public function bills()
    {
        return $this->hasMany('App\Models\Bill', 'invoice_id');
    }
    
    
  

}
