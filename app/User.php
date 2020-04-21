<?php

namespace App;

use App\Models\Cart;
use App\Models\categoryUser;
use App\Models\Category;
use App\Models\City;
use App\Models\NotificationMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

use auth;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,SoftDeletes;

    protected $guard = 'user';
    protected $hidden = ['password', 'remember_token', 'created_at', 'updated_at', 'deleted_at', 'pivot'];
    protected $fillable = ['name', 'email', 'mobile', 'password', 'status', 'type', 'parent_id', 'image'];
    protected $appends = ['office_id'];
    //protected $with = ['office_activities'];


    public function role()
    {
        return $this->belongsTo('App\Models\RoleGroup', 'role_group_id', 'id')->withTrashed();
    }


    public function zone()
    {
        return $this->belongsTo('App\Models\Zone', 'zone_id', 'id')->withTrashed();
    }



    public function getOfficeIdAttribute(){
        if($this->parent_id == 0){
            return $this->id;
        }else{
            return $this->parent_id;
        }
    }
    
    

    public function office_activities()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\ActivityProject', 'office_id','id');
        }else{
            return $this->hasMany('App\Models\ActivityProject', 'office_id','parent_id');
        }
    }


    public function getImageAttribute($value)
    {
        if($value){
            return url('uploads/images/users/' . $value);
        }else{
            return url('uploads/images/users/defualtUser.jpg');
        }
    }
    

    public function getTypeAttribute($value)
    {
        return (string)$value;
    }


    public function getPhoneAttribute($value)
    {
        if ($value != null)
            return $value;
        return "";
    }


    public function getLatAttribute($value)
    {
        if ($value != null)
            return $value;
        return "";
    }


    public function getLanAttribute($value)
    {
        if ($value != null)
            return $value;
        return "";
    }


    public function getLocationAttribute($value)
    {
        if ($value != null)
            return $value;
        return "";
    }
    

    public function notification()
    {
        return $this->hasMany(NotificationMessage::class);
    }


    public function city()
    {
        return $this->belongsTo(City::class, 'city_id')->withTrashed();
    }
    
    
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id')->withTrashed();
    }
    

    public function office_countries()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficeCountry', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficeCountry', 'office_id', 'parent_id');
        }
    }


    public function office_lawsuits()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficeLawsuit', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficeLawsuit', 'office_id', 'parent_id');
        }
    }


    public function office_contenders()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficeContender', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficeContender', 'office_id', 'parent_id');
        }
    }


    public function office_consultations()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficeConsultation', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficeConsultation', 'office_id', 'parent_id');
        }
    }


    public function office_task_types()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficeTaskType', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficeTaskType', 'office_id', 'parent_id');
        }
    }


    public function office_task_status()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficeTaskStatus', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficeTaskStatus', 'office_id', 'parent_id');
        }
    }


    public function office_discount_types()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficeDiscountType', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficeDiscountType', 'office_id', 'parent_id');
        }
    }


    public function office_invoice_outputs()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficeInvoiceOutput', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficeInvoiceOutput', 'office_id', 'parent_id');
        }
    }


    public function office_payment_methods()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficePaymentMethod', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficePaymentMethod', 'office_id', 'parent_id');
        }
    }


    public function offices_aspect_expenses()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\OfficeAspectExpense', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\OfficeAspectExpense', 'office_id', 'parent_id');
        }
    }



    public function office_banks()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\Bank', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\Bank', 'office_id', 'parent_id');
        }
    }



    public function office_employees()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\User', 'parent_id', 'id');
        }else{
            return $this->hasMany('App\User', 'parent_id', 'parent_id');
        }
    }


    public function office_bills()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\Bill', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\Bill', 'office_id', 'parent_id');
        }
    }
    
    
    public function office_clients()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\Client', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\Client', 'office_id', 'parent_id');
        }
    }
    
    
    public function office_projects()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\Project', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\Project', 'office_id', 'parent_id');
        }
    }

    
    public function office_hours()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\ProjectHour', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\ProjectHour', 'office_id', 'parent_id');
        }
    }
    
    

    public function office_invoices()
    {
        if($this->parent_id == 0){
            return $this->hasMany('App\Models\Invoice', 'office_id', 'id');
        }else{
            return $this->hasMany('App\Models\Invoice', 'office_id', 'parent_id');
        }
    }



}
