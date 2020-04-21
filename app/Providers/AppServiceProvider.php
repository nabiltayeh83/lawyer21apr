<?php
namespace App\Providers;

use App\Admin;
use App\User;
use App\Models\AreaRequest;
use App\Models\Contact;
use App\Models\Language;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\Car;
use App\Models\Area;
use App\Models\Project;
use App\Models\Report;
use App\Models\Client;
use App\Models\Task;
use App\Models\Country;
use App\Models\CountryTranslation;
use App\Models\City;

use App\Models\Zone;

use App\Models\Invoice;
use App\Models\Field;
use App\Models\OfficeSetting;
use App\Models\Document;
use App\Models\Expense;
use App\Models\AspectExpense;
use App\Models\AspectExpenseTranslation;

use App\Models\InvoiceOutput;
use App\Models\ReportOutput;

use App\Models\PaymentMethod;

use App\Models\RemindTime;
use App\Models\RemindTimeTranslation;


use App\Models\TaskType;
use App\Models\TaskTypeTranslation;


use App\Models\TaskStatus;
use App\Models\TaskstatusTranslation;


use App\Models\TaskCategory;
use App\Models\TaskCategoryTranslation;


use App\Models\Workgroup;
use App\Models\WorkgroupTranslation;


use App\Models\Department;
use App\Models\RoleGroup;



use Carbon\Carbon;

use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function ($view)
        {


            if(Auth::check()){

                
                $projects = Project::where('office_id', Auth::user()->office_id)->orderBy('id', 'desc')->get(); 
                $reports = Report::where('office_id', Auth::user()->office_id)->get(); 
                $invoices = Invoice::where('office_id', Auth::user()->office_id)->get();
                $work_groups = Workgroup::where('office_id', Auth::user()->office_id)->get();
                $clients  = Client::where('office_id', Auth::user()->office_id)->get();
                $invoices_outputs  = InvoiceOutput::where('status', 'active')->get();
                $payment_methods  = PaymentMethod::where('status', 'active')->get();
                
                $reports_outputs  = ReportOutput::where('status', 'active')->get();
                $clients_this_month  = Client::where('office_id', Auth::user()->office_id)->whereMonth('created_at', Carbon::now()->month)->count();
                $projects_this_month = Project::where('office_id', Auth::user()->office_id)->whereMonth('created_at', Carbon::now()->month)->count();
                $extra_fields = Field::where('office_id', Auth::user()->office_id)->where('apply_to', 'all_projects')->get();
                $tasks  = Task::where('office_id', Auth::user()->office_id)->orderBy('created_at', 'asc')->get();
                $office_settings  = OfficeSetting::where('office_id', Auth::user()->office_id)->first();
                $folders = Document::where('office_id', Auth::user()->office_id)->where('parent_id', 0)->get();


            }
            else{
                $projects = '';
                $work_groups = '';
                $clients = '';
                $clients_this_month = '';
                $projects_this_month = '';
                $tasks = '';
                $folders = '';
                $extra_fields = '';
                $invoices = '';
                $office_settings = '';
                $invoices_outputs = '';
                $reports_outputs = '';
                $reports = '';
                $payment_methods = '';
            }

            //...with this variable
            $view->with([
            'setting' => Setting::query()->first(),
            'locales'=> Language::all(),
            'admin'=>Admin::first(),
            'contact'=> Contact::where('read',0)->count(),
            'areas'=> Area::query()->count(),
            'count_users' => User::where('type', 1)->count(),
            'lawyer_offices' => User::where('type', 1)->count(),
            'employees' => User::where('type', 2)->where('parent_id', 0)->count(),
            'area_request'=> AreaRequest::query()->count(),
            'task_categories' => TaskCategory::all(),
            'reminer_time' => RemindTime::all(),
            'projects' => $projects,
            'invoices' => $invoices,
            'work_groups' => $work_groups,
            'clients'  => $clients,
            'clients_this_month' => $clients_this_month,
            'projects_this_month' => $projects_this_month,
            'tasks' => $tasks,
            'aspect_expense' => AspectExpense::where('status', 'active')->get(),
            'folders' => $folders,
            'extra_fields' => $extra_fields,
            'office_settings' => $office_settings,
            'invoices_outputs' => $invoices_outputs,
            'reports_outputs' => $reports_outputs,
            'reports' => $reports,
            'payment_methods' => $payment_methods,
            'departments' => Department::where('status', 'active')->get(),
            'roles' => RoleGroup::where('status', 'active')->get(),
            'countries' => Country::where('status', 'active')->get(),
            'zones' => Zone::all()

        ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

