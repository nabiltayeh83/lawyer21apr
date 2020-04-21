<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\User;

use PDF;

use Carbon\Carbon;

use App\Models\City;
use App\Models\CityTranslation;
use Illuminate\Support\Arr;
use App\Models\Attachtype;
use App\Models\AttachtypeTranslation;
use App\Models\Language;
use App\Models\LanguageTranslation;
use App\Models\Attachment;
use App\Models\Client;
use App\Models\Task;
use App\Models\Role;
use App\Models\RoleTranslation;
use App\Models\Representative;
use App\Models\Card;
use App\Models\Note;
use App\Models\Project;
use App\Models\Expense;
use App\Models\AspectExpense;
use App\Models\AspectExpenseTranslation;

use Dotenv\Exception\ValidationException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Models\Activity;
use App\Models\ActivityTranslation;
use App\Models\ActivityProject;


use Auth;
use Session;

class ExpenseController extends Controller
{

    public function index(Request $request)
    {
           if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        $items = Expense::where('office_id', Auth::user()->office_id)->orderBy('expense_date', 'asc')->get();
        return view('website.expenses.home', ['items' => $items]);
    }



   public function expenseFilterStatus($status)
    {
          if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        if($status == 'all'){
            $items = Expense::where('office_id', Auth::user()->office_id)->orderBy('expense_date', 'asc')->get();
        }

        else{
            $items = Expense::where('office_id', Auth::user()->office_id)->where('expense_status', $status)->orderBy('expense_date', 'asc')->get();
        }


        $expenseFilter = view('website.extraBlade.filters.expenseFilter')->with(['expenseFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'expenseFilter' => $expenseFilter ];
    }



    public function expenseFilterText($text)
    {
          if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        $items = Expense::where('office_id', Auth::user()->office_id)->where('expense_details', 'like', "%$text%")->orderBy('expense_date', 'asc')->get();

        $expenseFilter = view('website.extraBlade.filters.expenseFilter')->with(['expenseFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'expenseFilter' => $expenseFilter ];
    }



   public function expenseFilterForm(Request $request)
    {
          if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        $items = Expense::where('office_id', Auth::user()->office_id);


        if(isset($request->aspect_expense_id)){
            $items->where('aspect_expense_id', $request->aspect_expense_id);
        }

        if(isset($request->expense_status)){
            $items->where('expense_status', $request->expense_status);
        }

        if(isset($request->project_id)){
            $items->where('project_id', $request->project_id);
        }

        if(isset($request->responsible_lawyer)){
            $items->where('responsible_lawyer', $request->responsible_lawyer);
        }

        if(isset($request->from_date) and isset($request->to_date)){
            $from_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->from_date)));
            $to_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->to_date)));

            $items->whereBetween('expense_date', [$from_date, $to_date]);
        }

        $items = $items->orderBy('expense_date', 'asc')->get();

        $expenseFilter = view('website.extraBlade.filters.expenseFilter')->with(['expenseFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'expenseFilter' => $expenseFilter ];
    }



    public function create()
    {
          if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        return view('website.expenses.create');
    }



    public function InvoiceExpense(Request $request)
    {


        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'project_id' => "required",
            'aspect_expense_id' => "required",
            'expense_date' => "required",
            'total_amount' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $expense = new Expense();

        $expense->office_id = Auth::user()->office_id;
        $expense->project_id = $request->project_id;
        $expense->aspect_expense_id = $request->aspect_expense_id;
        $expense->reference_number = $request->reference_number? $request->reference_number : '' ;
        $expense->expense_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->expense_date)));
        $expense->total_amount = $request->total_amount;
        $expense->expense_details = $request->expense_details? $request->expense_details : '';
        $expense->expense_office_details = $request->expense_office_details? $request->expense_office_details : '';
        $expense->responsible_lawyer = $request->responsible_lawyer;
        $expense->save();

        $projectExpenses = view('website.extraBlade.invoices.newProjectExpenses')->with(['projectExpenses' => $expense])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectExpenses' => $projectExpenses ];

    }




    public function ReportExpense(Request $request)
    {

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'project_id' => "required",
            'aspect_expense_id' => "required",
            'expense_date' => "required",
            'total_amount' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $expense = new Expense();

        $expense->office_id = Auth::user()->office_id;
        $expense->project_id = $request->project_id;
        $expense->aspect_expense_id = $request->aspect_expense_id;
        $expense->reference_number = $request->reference_number;
        $expense->expense_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->expense_date)));
        $expense->total_amount = $request->total_amount;
        $expense->expense_details = $request->expense_details;
        $expense->expense_office_details = $request->expense_office_details;
        $expense->responsible_lawyer = $request->responsible_lawyer;
        $expense->save();

        $projectExpenses = view('website.extraBlade.reports.newProjectExpenses')->with(['projectExpenses' => $expense])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectExpenses' => $projectExpenses ];

    }




    public function store(Request $request)
    {

  if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'project_id' => "required",
            'aspect_expense_id' => "required",
            'expense_date' => "required",
            'total_amount' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        if(isset($request->expense_date)){
            if(date("Y", strtotime($request->expense_date)) == '1970'){
                $expense_date = Arr::get(getDates($request->expense_date), 'gregorian_date');
                $expense_date_hijri = Arr::get(getDates($request->expense_date), 'hijri_date');
            }
            else{
                $expense_date = Arr::get(getDates(date("Y-m-d", strtotime($request->expense_date))), 'gregorian_date');
                $expense_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->expense_date))), 'hijri_date');
                $expense_date_hijri = convertAr2En($expense_date_hijri);
            }
        }


        $expense = new Expense();

        $expense->office_id = Auth::user()->office_id;
        $expense->project_id = $request->project_id;
        $expense->aspect_expense_id = $request->aspect_expense_id;
        $expense->reference_number = $request->reference_number;
        $expense->expense_date = $expense_date;
        $expense->expense_date_hijri = $expense_date_hijri;
        $expense->total_amount = $request->total_amount;
        $expense->expense_details = $request->expense_details;
        $expense->expense_office_details = $request->expense_office_details;
        $expense->responsible_lawyer = $request->responsible_lawyer;
        $expense->save();


        if(isset($request->attachment_name)){
        foreach ($request->attachment_name as $i => $value){
            if(isset($request->attachment_name[$i]) && isset($request->attachfile[$i])){
                $file = $request->attachfile[$i];
                $extension = $file->getClientOriginalExtension();
                $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'tas.' .$extension;
                $destinationPath = 'uploads/websitefiles/attachments';
                $file->move($destinationPath,$filename);
                $attachment[] = [
                    'attachment_name' => $request->attachment_name[$i],
                    'file' => $filename,
                    'attachmentable_id' => $expense->id,
                    'attachmentable_type' => "App\Models\Expense",
                ];
            }
        }
        isset($attachment)? Attachment::insert($attachment): '';
        }

        $activities_projects = new ActivityProject();
        $activities_projects->office_id = Auth::user()->office_id;
        $activities_projects->action_user_id = Auth::user()->id;
        $activities_projects->activity_id = 4;
        $activities_projects->project_id = $request->project_id;
        $activities_projects->save();

        Session::flash('msg', __('website.data_added'));

        if(isset($request->saveway) && $request->saveway == 1){
            return redirect()->back();
        }
        else{
            return redirect('/expenses');
        }

    }


    public function show($id)
    {
          if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        $item  = Expense::findOrFail($id);
        return view('website.expenses.expenseDetails', [
            'item' => $item,
        ]);
    }



    public function canceledExpense($expense_id)
    {
          if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        $item  = Expense::findOrFail($expense_id);
        $item->expense_status = 'canceled';
        $item->save();
    }



    public function exportAllExpensesPDF(){

        if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        $expenses = Expense::where('office_id', Auth::user()->office_id)->get();

        $data =
        [
           'expenses' => $expenses,
           'logo' => 'assets/img/logo.svg',
           'signature' => 'assets/img/signature2x.png',

        ];

        $pdf = PDF::loadView('website.expenses.exportAllExpensesPDF', $data);
        return $pdf->stream('expenses.pdf');
     }




    public function edit($id)
    {
          if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        $item = Expense::findOrFail($id);
        return view('website.expenses.edit', [
            'item' => $item,
        ]);
    }



    public function update(Request $request, $id)
    {

  if(!user_role(7)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'project_id' => "required",
            'aspect_expense_id' => "required",
            'expense_date' => "required",
            'total_amount' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        if(isset($request->expense_date)){
            if(date("Y", strtotime($request->expense_date)) == '1970'){
                $expense_date = Arr::get(getDates($request->expense_date), 'gregorian_date');
                $expense_date_hijri = Arr::get(getDates($request->expense_date), 'hijri_date');
            }
            else{
                $expense_date = Arr::get(getDates(date("Y-m-d", strtotime($request->expense_date))), 'gregorian_date');
                $expense_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->expense_date))), 'hijri_date');
                $expense_date_hijri = convertAr2En($expense_date_hijri);
            }
        }

        $expense = Expense::findOrFail($id);

        if(isset($request->project_id)){
            $expense->project_id = $request->project_id;
        }else{
            $expense->project_id = null;
        }

        $expense->aspect_expense_id = $request->aspect_expense_id;
        $expense->reference_number = $request->reference_number;
        $expense->expense_date = $expense_date;
        $expense->expense_date_hijri = $expense_date_hijri;
        $expense->total_amount = $request->total_amount;
        $expense->expense_details = $request->expense_details;
        $expense->expense_office_details = $request->expense_office_details;
        $expense->responsible_lawyer = $request->responsible_lawyer;
        $expense->save();


        //////////////////////////// Old Attach File ////////////////////////
        $attachments = Attachment::where('attachmentable_id', $id)->where('attachmentable_type', 'App\Models\Task')->get();

        foreach($attachments as $attach){
            if (in_array($attach->id, $request->oldattach_id)){

                $attachments = Attachment::find($attach->id);

                $attachments->attachment_name =  $request->input("oldattachment_name".$attach->id);
                $oldattachfile = $request->file("oldattachfile".$attach->id);

                if(isset($oldattachfile)){
                    $file = $oldattachfile;
                    $extension = $file->getClientOriginalExtension();
                    $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'cli.' .$extension;
                    $destinationPath = 'uploads/websitefiles/attachments';
                    $file->move($destinationPath,$filename);
                    $attachments->file = $filename;
                }
                else { $attachments->file =  $request->input("oldfile_uploaded".$attach->id); }

                $attachments->save();

            } else {
                Attachment::findOrFail($attach->id)->delete();
            }

        }



        ///////////////////////////// New Attach File //////////////////////////
        foreach ($request->attachment_name as $i => $value){

            if(isset($request->attachment_name[$i]) && isset($request->attachfile[$i])){

                $file = $request->attachfile[$i];
                $extension = $file->getClientOriginalExtension();
                $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'cli.' .$extension;
                $destinationPath = 'uploads/websitefiles/attachments';
                $file->move($destinationPath,$filename);
                $attachment[] = [
                    'attachment_name' => $request->attachment_name[$i],
                    'file' => $filename,
                    'attachmentable_id' => $expense->id,
                    'attachmentable_type' => "App\Models\Expense",
                ];
            }
        }
        isset($attachment)? Attachment::insert($attachment): '';

        Session::flash('msg', __('website.data_added'));

        if(isset($request->saveway) && $request->saveway == 1){
            return redirect('/expenses/create');
        } else{
            return redirect('/expenses');
        }

    }


    public function destroy($id)
    {
    }

}
