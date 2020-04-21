<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\User;

use Redirect;
use PDF;

use Carbon\Carbon;

use App\Models\City;
use App\Models\CityTranslation;

use App\Models\Attachtype;
use App\Models\AttachtypeTranslation;
use App\Models\Language;
use App\Models\OfficeSetting;

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
use App\Models\Invoice;
use App\Models\ProjectHour;
use App\Models\FlatFee;

use App\Models\InvoiceExpense;
use App\Models\InvoiceHour;
use App\Models\InvoiceFlatFee;
use App\Models\InvoiceInvoiceOutput;

use App\Models\InvoiceOutput;
use App\Models\InvoiceOutputTranslation;

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

use App\Models\Bill;
use Illuminate\Support\Arr;


use Auth;
use Session;

class InvoiceController extends Controller
{


    public function index()
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $bills = Bill::where('office_id', Auth::user()->office_id)->orderBy('payment_date', 'asc')->get();
        $office_invoices  = Invoice::where('office_id', Auth::user()->office_id)->orderBy('claim_date', 'asc')->get();
        return view('website.invoices.home', ['office_invoices' => $office_invoices,'bills' => $bills]);
    }


    public function invoiceFilterStatus($status)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        if($status == 'all'){
            $items = Invoice::where('office_id', Auth::user()->office_id)->orderBy('claim_date', 'asc')->get();
        }

        else{
            $items = Invoice::where('office_id', Auth::user()->office_id)->where('status', $status)->orderBy('claim_date', 'asc')->get();
        }

        $invoiceFilter = view('website.extraBlade.filters.invoiceFilter')->with(['invoiceFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'invoiceFilter' => $invoiceFilter ];
    }


    public function invoiceFilterText($text)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $items = Invoice::where('office_id', Auth::user()->office_id)->where('client_address', 'like', "%$text%")->orderBy('claim_date', 'asc')->get();

        $invoiceFilter = view('website.extraBlade.filters.invoiceFilter')->with(['invoiceFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'invoiceFilter' => $invoiceFilter ];
    }


    public function invoiceFilterForm(Request $request)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $items  = Invoice::where('office_id', Auth::user()->office_id);

        $client_id = $request->client_id;
        $project_id = $request->project_id;
        $status = $request->status;
        $responsible_lawyer = $request->responsible_lawyer;

        if(isset($client_id)){
            $items->where('client_id', $client_id);
        }

        if(isset($project_id)){
            $items->where('project_id', $project_id);
        }
        
        if(isset($status)){
            $items->where('status', $status);
        }

        if(isset($responsible_lawyer)){
            $items->where('responsible_lawyer', $responsible_lawyer);
        }

        if(isset($request->from_date) and isset($request->to_date)){
            $from_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->from_date)));
            $to_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->to_date)));
            $items->whereBetween('claim_date', [$from_date, $to_date]);
        }

        $items = $items->orderBy('claim_date', 'asc')->get();

        $invoiceFilter = view('website.extraBlade.filters.invoiceFilter')->with(['invoiceFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'invoiceFilter' => $invoiceFilter ];
    }



    public function completeInvoice($invoice_id)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $item  = Invoice::findOrFail($invoice_id);
        $item->status = 'approved';
        $item->save();
    }




    public function create()
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        return view('website.invoices.create');
    }
    
    
    public function expenseInvoice($hour_id)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }
        $expense = Expense::findOrFail($hour_id);
        return view('website.invoices.create', ['expense' => $expense]);
    }


    
    public function hourInvoice($hour_id)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }
        $hour = ProjectHour::findOrFail($hour_id);
        return view('website.invoices.create', ['hour' => $hour]);
    }


    public function store(Request $request)
    {

        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'client_id' => "nullable",
            'project_id' => "required",
            'release_date' => "required",
            'claim_date' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        if(isset($request->release_date)){
            if(date("Y", strtotime($request->release_date)) == '1970'){
                $release_date = Arr::get(getDates($request->release_date), 'gregorian_date');
                $release_date_hijri = Arr::get(getDates($request->release_date), 'hijri_date');
            }
            else{
                $release_date = Arr::get(getDates(date("Y-m-d", strtotime($request->release_date))), 'gregorian_date');
                $release_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->release_date))), 'hijri_date');
                $release_date_hijri = convertAr2En($release_date_hijri);
            }
        }


        if(isset($request->claim_date)){
            if(date("Y", strtotime($request->claim_date)) == '1970'){
                $claim_date = Arr::get(getDates($request->claim_date), 'gregorian_date');
                $claim_date_hijri = Arr::get(getDates($request->claim_date), 'hijri_date');
            }
            else{
                $claim_date = Arr::get(getDates(date("Y-m-d", strtotime($request->claim_date))), 'gregorian_date');
                $claim_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->claim_date))), 'hijri_date');
                $claim_date_hijri = convertAr2En($claim_date_hijri);
            }
        }

        $item = new Invoice();

        $invoices_count = Invoice::where('office_id', Auth::user()->office_id)->count();
        $invoice_number = str_pad($invoices_count+1, 5, "0", STR_PAD_LEFT);

        if(isset($request->client_id)){
            $client_id = $request->client_id;
        }else{
            $client_id = Project::findOrFail($request->project_id)->client_id;
        }

        $item->office_id = Auth::user()->office_id;
        $item->client_id = $client_id;
        $item->project_id = $request->project_id;
        $item->invoice_number = $invoice_number;
        $item->vat_status = isset($request->vat_status)? $request->vat_status : null;

        if($item->vat_status == 'yes'){
            $office_settings = OfficeSetting::where('office_id', Auth::user()->office_id)->first();
                if($office_settings){
                    $item->vat = $office_settings->office_vat;
                }
        }

        $item->claim_date = $claim_date;
        $item->claim_date_hijri = $claim_date_hijri;


        $item->release_date = $release_date;
        $item->release_date_hijri = $release_date_hijri;

        $item->office_address = isset($request->office_address)? $request->office_address : null;
        $item->client_address = isset($request->client_address)? $request->client_address : null;
        $item->final_total = isset($request->final_total)? $request->final_total : null;
        $item->discount_status = isset($request->discount_status)? 'yes':'no';
        $item->discount_name = isset($request->discount_name)? $request->discount_name : null;
        $item->discount_type_id = isset($request->discount_type_id)? $request->discount_type_id : null;
        $item->discount_amount = isset($request->discount_amount)? $request->discount_amount : null;

        if(isset($request->status)){
            $item->status = $request->status;
        }

        $item->responsible_lawyer = Auth::user()->id;
        $item->save();

        if(isset($request->invoices_outputs)){
            foreach($request->invoices_outputs as $i => $value){
                $invoices_outputs[] = [
                    'invoice_id' => $item->id,
                    'invoice_output_id' => $request->invoices_outputs[$i]
                ];
            }
            isset($invoices_outputs)? InvoiceInvoiceOutput::insert($invoices_outputs) : '';
        }

        if(isset($request->projectHours)){
            foreach ($request->projectHours as $one){
                $projectHours[] = [
                    'invoice_id' => $item->id,
                    'hour_id' => $one,
                ];
            }
            isset($projectHours)? InvoiceHour::insert($projectHours): '';
            }


            if(isset($request->projectExpenses)){
                foreach ($request->projectExpenses as $one){
                    Expense::findOrFail($one)->update(['expense_status' => 'certified']);
                    $projectExpenses[] = [
                        'invoice_id' => $item->id,
                        'expense_id' => $one,
                    ];
                }
                isset($projectExpenses)? InvoiceExpense::insert($projectExpenses): '';
            }



            if(isset($request->projectFlatsFees)){
                foreach ($request->projectFlatsFees as $one){
                    $projectFlatsFees[] = [
                        'invoice_id' => $item->id,
                        'flat_fee_id' => $one,
                    ];
                }
                isset($projectFlatsFees)? InvoiceFlatFee::insert($projectFlatsFees): '';
            }


            if(isset($request->attachment_name)){
                foreach ($request->attachment_name as $i => $value){
                    if(isset($request->attachment_name[$i]) && isset($request->attachfile[$i])){
                        $file = $request->attachfile[$i];
                        $extension = $file->getClientOriginalExtension();
                        $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'inv.' .$extension;
                        $destinationPath = 'uploads/websitefiles/attachments';
                        $file->move($destinationPath,$filename);
                        $attachment[] = [
                            'attachment_name' => $request->attachment_name[$i],
                            'file' => $filename,
                            'attachmentable_id' => $item->id,
                            'attachmentable_type' => "App\Models\Invoice",
                        ];
                    }
                }
                isset($attachment)? Attachment::insert($attachment): '';
            }



            if(isset($request->saveway) && $request->saveway == 1){
                return redirect()->back();
            }
            else{
                return redirect('/invoices');
            }
    }



    public function update(Request $request, $id)
    {

        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $validator = Validator::make($request->all(), []);

        $rules = [
            'client_id' => "required",
            'project_id' => "required",
            'vat_status' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if(isset($request->release_date)){
            if(date("Y", strtotime($request->release_date)) == '1970'){
                $release_date = Arr::get(getDates($request->release_date), 'gregorian_date');
                $release_date_hijri = Arr::get(getDates($request->release_date), 'hijri_date');
            }
            else{
                $release_date = Arr::get(getDates(date("Y-m-d", strtotime($request->release_date))), 'gregorian_date');
                $release_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->release_date))), 'hijri_date');
                $release_date_hijri = convertAr2En($release_date_hijri);
            }
        }

        
        if(isset($request->claim_date)){
            if(date("Y", strtotime($request->claim_date)) == '1970'){
                $claim_date = Arr::get(getDates($request->claim_date), 'gregorian_date');
                $claim_date_hijri = Arr::get(getDates($request->claim_date), 'hijri_date');
            }
            else{
                $claim_date = Arr::get(getDates(date("Y-m-d", strtotime($request->claim_date))), 'gregorian_date');
                $claim_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->claim_date))), 'hijri_date');
                $claim_date_hijri = convertAr2En($claim_date_hijri);
            }
        }

        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $item = Invoice::findOrFail($id);


        $item->client_id = $request->client_id;
        $item->project_id = $request->project_id;
        $item->vat_status = $request->vat_status;

        if($item->vat_status == 'no'){
            $item->vat = null;
        }else{
            $office_settings = OfficeSetting::where('office_id', Auth::user()->office_id)->first();
            if($office_settings){
                $item->vat = $office_settings->office_vat;
            }
        }

        $item->claim_date = $claim_date;
        $item->claim_date_hijri = $claim_date_hijri;


        $item->release_date = $release_date;
        $item->release_date_hijri = $release_date_hijri;

        $item->office_address = $request->office_address;
        $item->client_address = $request->client_address;
        $item->final_total = $request->final_total;

        $item->discount_status = isset($request->discount_status)? 'yes':'no';

        if($item->discount_status == 'no'){
            $item->discount_name = '';
            $item->discount_type_id = null;
            $item->discount_amount = null;
        }else{
            $item->discount_name = $request->discount_name;
            $item->discount_type_id = $request->discount_type_id;
            $item->discount_amount = $request->discount_amount;
        }

        if(isset($request->status)){
            $item->status = $request->status;
        }

        $item->save();

        InvoiceInvoiceOutput::where('invoice_id', $id)->delete();

        if(isset($request->invoices_outputs)){
            foreach($request->invoices_outputs as $i => $value){
                $invoices_outputs[] = [
                    'invoice_id' => $item->id,
                    'invoice_output_id' => $request->invoices_outputs[$i]
                ];
            }
            isset($invoices_outputs)? InvoiceInvoiceOutput::insert($invoices_outputs) : '';
        }

        InvoiceHour::where('invoice_id', $id)->delete();

        if(isset($request->projectHours)){
            foreach ($request->projectHours as $one){
                $projectHours[] = [
                    'invoice_id' => $item->id,
                    'hour_id' => $one,
                ];
            }
            isset($projectHours)? InvoiceHour::insert($projectHours): '';
            }


            InvoiceExpense::where('invoice_id', $id)->delete();
            Expense::where('project_id', $request->project_id)->update(['expense_status' => 'draft']);

            if(isset($request->projectExpenses)){
                foreach ($request->projectExpenses as $one){
                    Expense::findOrFail($one)->update(['expense_status' => 'certified']);
                    $projectExpenses[] = [
                        'invoice_id' => $item->id,
                        'expense_id' => $one,
                    ];
                }
                isset($projectExpenses)? InvoiceExpense::insert($projectExpenses): '';
                }


            InvoiceFlatFee::where('invoice_id', $id)->delete();

            if(isset($request->projectFlatsFees)){
                foreach ($request->projectFlatsFees as $one){
                    $projectFlatsFees[] = [
                        'invoice_id' => $item->id,
                        'flat_fee_id' => $one,
                    ];
                }
                isset($projectFlatsFees)? InvoiceFlatFee::insert($projectFlatsFees): '';
                }


             //////////////////////////// Old Attach File ////////////////////////
             $attachments = Attachment::where('attachmentable_id', $id)->where('attachmentable_type', 'App\Models\Invoice')->get();

             foreach($attachments as $attach){
                 if (in_array($attach->id, $request->oldattach_id)){

                     $attachments = Attachment::find($attach->id);

                     $attachments->attachment_name =  $request->input("oldattachment_name".$attach->id);
                     $oldattachfile = $request->file("oldattachfile".$attach->id);

                     if(isset($oldattachfile)){
                         $file = $oldattachfile;
                         $extension = $file->getClientOriginalExtension();
                         $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'inv.' .$extension;
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
                         'attachmentable_id' => $item->id,
                         'attachmentable_type' => "App\Models\Invoice",
                     ];
                 }
             }
             isset($attachment)? Attachment::insert($attachment): '';




        if(isset($request->saveway) && $request->saveway == 1){
            return redirect()->back();
        }
        else{
            return redirect('/invoices');
        }

    }

    public function show($id)
    {
        $item  = Invoice::findOrFail($id);
        return view('website.invoices.invoicesDetails', [
            'item' => $item,
        ]);
    }


    public function getInvoiceData($id)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        return Invoice::findOrFail($id);

    }



    public function invoicePreview($id)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $item  = Invoice::findOrFail($id);
        return view('website.invoices.invoicePreview', ['item' => $item]);
    }




    public function invoiceExportPDF($id){

        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $invoice = Invoice::findOrFail($id);

        $data =
        [
           'invoiceID' => $invoice->id,
           'client' => $invoice->client->name,
           'project' => $invoice->project->name,
           'invoice_number' => $invoice->invoice_number,
           'vat_status' => $invoice->vat_status,
           'vat' => $invoice->vat,
           'release_date' => $invoice->release_date,
           'claim_date' => $invoice->claim_date,
           'office_address' => $invoice->office_address,
           'client_address' => $invoice->client_address,
           'final_total' => $invoice->final_total,
           'discount_status' => $invoice->discount_status,
           'discount_name' => $invoice->discount_name,
           'discount_type_id' => $invoice->discount_type_id,
           'invoiceHours' => $invoice->invoiceHours,
           'invoice_outputs' => $invoice->invoice_outputs,
           'invoiceExpenses' => $invoice->invoiceExpenses,
           'invoiceFlatsFees' => $invoice->invoiceFlatsFees,
           'invoice_amount' => $invoice->invoice_amount,
           'logo' => 'assets/img/logo.svg',
           'signature' => 'assets/img/signature2x.png',

        ];

        $pdf = PDF::loadView('website.invoices.invoiceExportPDF', $data);
        return $pdf->stream('invoice' . $invoice->invoice_number . '.pdf');

     }




     public function exportAllInvoicesPDF(){

        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $invoices = Invoice::where('office_id', Auth::user()->office_id)->get();

        $data =
        [
           'invoices' => $invoices,
           'logo' => 'assets/img/logo.svg',
           'signature' => 'assets/img/signature2x.png',

        ];

        $pdf = PDF::loadView('website.invoices.exportAllInvoicesPDF', $data);
        return $pdf->stream('invoices.pdf');
     }





    public function edit($id)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $item = Invoice::findOrFail($id);
        $project_id = $item->project_id;


        $project_hours = ProjectHour::where('project_id', $project_id)->get();
        $invoice_hours = InvoiceHour::where('invoice_id', $id)->pluck('hour_id')->toArray();


        $project_expenses = Expense::where('project_id', $project_id)->get();
        $invoice_expenses = InvoiceExpense::where('invoice_id', $id)->pluck('expense_id')->toArray();


        $project_flats_fees = FlatFee::where('project_id', $project_id)->get();
        $invoice_flats_fees = InvoiceFlatFee::where('invoice_id', $id)->pluck('flat_fee_id')->toArray();



        $invoices_invoices_outputs = InvoiceInvoiceOutput::where('invoice_id', $id)->pluck('invoice_output_id')->toArray();

        return view('website.invoices.edit', [
            'item' => $item,
            'invoices_invoices_outputs' => $invoices_invoices_outputs,

            'project_hours' => $project_hours,
            'invoice_hours' => $invoice_hours,

            'project_expenses' => $project_expenses,
            'invoice_expenses' => $invoice_expenses,

            'project_flats_fees' => $project_flats_fees,
            'invoice_flats_fees' => $invoice_flats_fees

        ]);
    }






    public function destroy($id)
    {
    }

}
