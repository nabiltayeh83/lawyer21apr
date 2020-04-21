<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\User;
use App\Models\Permission;
use App\Models\Setting;
use App\Models\Area;
use App\Models\AreaRequest;
use App\Models\Car;
use App\Models\PromotionCode;
use App\Models\Order;

use App\Models\City;
use App\Models\Country;

use App\Models\Contact;
use App\Models\Booking;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class HomeController extends Controller
{
    
   
    public function index()
    {
        $admin=Admin::findOrFail(auth()->guard('admin')->user()->id);    
        return view('admin.home.dashboard');
    }


    public function getCities($id){
        return City::where('country_id', $id)->where('status', 'active')->get();
    }

    public function getCountries(){
        return Country::where('status', 'active')->get();
    }
    
    

    public function changeStatus($model,Request $request)
    {
        $role = "";
        if($model == "admins") $role = 'App\Admin';
        if($model == "areas") $role = 'App\Models\Area';
        if($model == "areaRequests") $role = 'App\Models\AreaRequest';
        if($model == "employees") $role = 'App\User';
        if($model == "users") $role = 'App\User';
        if($model == "role") $role = 'App\Models\Permission';
        if($model == "cars") $role = 'App\Models\Car';
        if($model == "promotions") $role = 'App\Models\PromotionCode';
        if($model == "orders") $role = 'App\Models\Order';
        if($model == "categories") $role = 'App\Models\Category';
        if($model == "countries") $role = 'App\Models\Country';
        if($model == "cities") $role = 'App\Models\City';
        if($model == "lawsuits") $role = 'App\Models\Lawsuit';
        if($model == "consultations") $role = 'App\Models\Consultation';
        if($model == "filesattachments") $role = 'App\Models\Attachtype';
        if($model == "personalcards") $role = 'App\Models\Card';
        if($model == "projectstatus") $role = 'App\Models\Projectstatus';
        if($model == "tasks_types") $role = 'App\Models\TaskType';
        if($model == "tasks_status") $role = 'App\Models\TaskStatus';
        if($model == "aspect_expenses") $role = 'App\Models\AspectExpense';
        if($model == "clients_descriptions") $role = 'App\Models\ClientDescription';
        if($model == "contenders") $role = 'App\Models\Contender';
        if($model == "zones") $role = 'App\Models\Zone';
        
        

        if($role !=""){
             if ($request->action == 'delete') {
                $role::query()->whereIn('id', $request->IDsArray)->delete();
            }
            else {
                if($request->action) {
                    $role::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->action]);
                }
            }
            return $request->action;
        }
        return false;
        
  
    }
     
 

 
}
