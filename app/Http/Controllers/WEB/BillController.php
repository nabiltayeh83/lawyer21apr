<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\User;
use Illuminate\Support\Arr;
use PDF;
use Carbon\Carbon;

use App\Models\City;
use App\Models\CityTranslation;

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
use App\Models\Invoice;
use App\Models\ProjectHour;

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

use Auth;
use Session;

class BillController extends Controller
{


    public function index(Request $request)
    {
        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $items = Bill::where('office_id', Auth::user()->office_id)->orderBy('payment_date', 'asc')->get();
        return view('website.bills.home', ['invoices' => $invoices]);
    }


    public function billFilterStatus($status)
    {
           if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        if($status == 'all'){
            $items = Bill::where('office_id', Auth::user()->office_id)->orderBy('payment_date', 'asc')->get();
        }

        else{
            $items = Bill::where('office_id', Auth::user()->office_id)->where('payment_method_id', $status)->orderBy('payment_date', 'asc')->get();
        }

        $billFilter = view('website.extraBlade.filters.billFilter')->with(['billFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'billFilter' => $billFilter ];
    }


    public function billFilterText($text)
    {
           if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $items = Bill::where('office_id', Auth::user()->office_id)->where('details', 'like', "%$text%")->orderBy('payment_date', 'asc')->get();

        $billFilter = view('website.extraBlade.filters.billFilter')->with(['billFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'billFilter' => $billFilter ];
    }



       public function billFilterForm(Request $request)
    {
           if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $items  = Bill::where('office_id', Auth::user()->office_id);

        $client_id = $request->client_id;
        $project_id = $request->project_id;
        $payment_method_id = $request->payment_method_id;
        $responsible_lawyer = $request->responsible_lawyer;

        if(isset($client_id)){
            $items->where('client_id', $client_id);
        }

        if(isset($project_id)){
            $items->where('project_id', $project_id);
        }
        
        if(isset($payment_method_id)){
            $items->where('payment_method_id', $payment_method_id);
        }

        if(isset($responsible_lawyer)){
            $items->where('responsible_lawyer', $responsible_lawyer);
        }

        if(isset($request->from_date) and isset($request->to_date)){
            $from_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->from_date)));
            $to_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->to_date)));
            $items->whereBetween('payment_date', [$from_date, $to_date]);
        }

        $items = $items->orderBy('payment_date', 'asc')->get();

        $billFilter = view('website.extraBlade.filters.billFilter')->with(['billFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'billFilter' => $billFilter ];
    }




    public function create()
    {
           if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        return view('website.bills.create');
    }


    public function store(Request $request)
    {
           if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $invoice = Invoice::findOrFail($request->invoice_id);
        $amount_remain = $invoice->invoice_amount-$invoice->invoice_bills;


        $validator = Validator::make($request->all(), []);

        $rules = [
            'client_id' => "required",
            'invoice_id' => "required",
            'payment_date' => "required",
            'payment_method_id' => "required",
            'bank_id' => "required",
            'amount' => "required|numeric|max:$amount_remain",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            'max' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        if(isset($request->payment_date)){
            if(date("Y", strtotime($request->payment_date)) == '1970'){
                $payment_date = Arr::get(getDates($request->payment_date), 'gregorian_date');
                $payment_date_hijri = Arr::get(getDates($request->payment_date), 'hijri_date');
            }
            else{
                $payment_date = Arr::get(getDates(date("Y-m-d", strtotime($request->payment_date))), 'gregorian_date');
                $payment_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->payment_date))), 'hijri_date');
                $payment_date_hijri = convertAr2En($payment_date_hijri);
            }
        }


        $item = new Bill();

        $item->office_id = Auth::user()->office_id;
        $item->client_id = $request->client_id;
        $item->invoice_id = $request->invoice_id;
        $item->project_id = $invoice->project_id;
        $item->payment_date = $payment_date;
        $item->payment_date_hijri = $payment_date_hijri;
        $item->payment_method_id = $request->payment_method_id;
        $item->reference_number = $request->reference_number;
        $item->bank_id = $request->bank_id;
        $item->client_account = $request->client_account;
        $item->amount = $request->amount;
        $item->details = $request->details;
        $item->responsible_lawyer = Auth::user()->id;
        $item->save();


        if(isset($request->attachment_name)){
            foreach ($request->attachment_name as $i => $value){
                if(isset($request->attachment_name[$i]) && isset($request->attachfile[$i])){
                    $file = $request->attachfile[$i];
                    $extension = $file->getClientOriginalExtension();
                    $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'bill.' .$extension;
                    $destinationPath = 'uploads/websitefiles/attachments';
                    $file->move($destinationPath,$filename);
                    $attachment[] = [
                        'attachment_name' => $request->attachment_name[$i],
                        'file' => $filename,
                        'attachmentable_id' => $item->id,
                        'attachmentable_type' => "App\Models\Bill",
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
            'invoice_id' => "required",
            'payment_date' => "required",
            'payment_method_id' => "required",
            'bank_id' => "required",
            'amount' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if(isset($request->payment_date)){
            if(date("Y", strtotime($request->payment_date)) == '1970'){
                $payment_date = Arr::get(getDates($request->payment_date), 'gregorian_date');
                $payment_date_hijri = Arr::get(getDates($request->payment_date), 'hijri_date');
            }
            else{
                $payment_date = Arr::get(getDates(date("Y-m-d", strtotime($request->payment_date))), 'gregorian_date');
                $payment_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->payment_date))), 'hijri_date');
                $payment_date_hijri = convertAr2En($payment_date_hijri);
            }
        }


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $item = Bill::findOrFail($id);

        $item->client_id = $request->client_id;
        $item->invoice_id = $request->invoice_id;
        $invoice = Invoice::findOrFail($request->invoice_id);
        $item->project_id = $invoice->project_id;
        $item->payment_date = $payment_date;
        $item->payment_date_hijri = $payment_date_hijri;
        $item->payment_method_id = $request->payment_method_id;
        $item->reference_number = $request->reference_number;
        $item->bank_id = $request->bank_id;
        $item->client_account = $request->client_account;
        $item->amount = $request->amount;
        $item->details = $request->details;
        $item->save();

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
            return redirect('invoices');
        }

    }

    public function show($id)
    {
           if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $item  = Bill::findOrFail($id);
        return view('website.bills.billDetails', [
            'item' => $item,
        ]);
    }



     public function exportAllBillsPDF(){

        if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $bills = Bill::where('office_id', Auth::user()->office_id)->get();

        $data =
        [
           'bills' => $bills,
           'logo' => 'assets/img/logo.svg',
           'signature' => 'assets/img/signature2x.png',

        ];

        $pdf = PDF::loadView('website.invoices.exportAllBillsPDF', $data);
        return $pdf->stream('bills.pdf');
     }


    public function edit($id)
    {
           if(!user_role(6)){
            return redirect()->route('HomePage');
        }

        $item = Bill::findOrFail($id);
        $clientInvoices = Invoice::where('client_id', $item->client_id)->get();
        return view('website.bills.edit', ['item' => $item, 'clientInvoices' => $clientInvoices]);
    }






    public function destroy($id)
    {
    }

}
