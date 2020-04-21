<?php

namespace App\Http\Controllers\WEB;

use App\Models\Client;
use App\Models\Project;
use App\Models\City;
use App\Models\Country;
use App\Models\Task;
use App\Models\ProjectHour;
use App\Models\Attachtype;
use App\Models\AttachtypeTranslation;
use App\Models\Attatchments;
use App\Models\CityTranslation;
use App\Models\ClientsAttachments;
use App\Models\CountryTranslation;
use App\Models\Language;
use App\Models\LanguageTranslation;
use App\Models\Role;
use App\Models\Report;
use App\Models\RoleGroup;

use App\Models\RoleTranslation;
use App\Models\Representative;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class HomeController extends Controller
{


    public function changeStatus($model,Request $request)
    {
        $role = "";
        if($model == "admins") $role = 'App\Admin';
        if($model == "employees") $role = 'App\User';
        if($model == "users") $role = 'App\User';
        if($model == "staff") $role = 'App\User';
        if($model == "roles_settings") $role = 'App\RoleGroup';

        if($model == "documents") $role = 'App\Models\Document';

        if($model == "role") $role = 'App\Models\Permission';
        if($model == "cars") $role = 'App\Models\Car';
        if($model == "promotions") $role = 'App\Models\PromotionCode';
        if($model == "categories") $role = 'App\Models\Category';
        if($model == "countries") $role = 'App\Models\Country';
        if($model == "clients") $role = 'App\Models\Client';
        if($model == "projects") $role = 'App\Models\Project';
        if($model == "tasks") $role = 'App\Models\Task';
        if($model == "hours") $role = 'App\Models\ProjectHour';
        if($model == "expenses") $role = 'App\Models\Expense';
        if($model == "reports") $role = 'App\Models\Report';
        if($model == "invoices") $role = 'App\Models\Invoice';
        if($model == "invoices") $role = 'App\Models\Invoice';
        if($model == "bills") $role = 'App\Models\Bill';



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
