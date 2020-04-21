<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

use App\User;
use App\Models\City;
use App\Models\ProjectField;
use App\Models\Task;
use App\Models\CityTranslation;

use App\Models\ClientDescription;
use App\Models\ClientDescriptionTranslation;
use App\Models\Attachtype;
use App\Models\AttachtypeTranslation;
use App\Models\Language;
use App\Models\LanguageTranslation;
use App\Models\Role;
use App\Models\RoleTranslation;

use App\Models\Bank;


use App\Models\OfficeLawsuit;
use App\Models\OfficeContender;
use App\Models\OfficeConsultation;
use App\Models\OfficeTaskType;
use App\Models\OfficeTaskStatus;
use App\Models\OfficeDiscountType;
use App\Models\OfficeInvoiceOutput;
use App\Models\OfficePaymentMethod;
use App\Models\OfficeAspectExpense;


use App\Models\Lawsuit;
use App\Models\Contender;
use App\Models\Consultation;
use App\Models\TaskType;
use App\Models\TaskStatus;
use App\Models\DiscountType;
use App\Models\InvoiceOutput;
use App\Models\PaymentMethod;
use App\Models\AspectExpense;


use App\Models\Projectstatus;
use App\Models\ProjectstatusTranslation;

use App\Models\Representative;
use App\Models\Zone;
use App\Models\Attachment;
use App\Models\Card;
use App\Models\Project;
use App\Models\Note;
use App\Models\OfficeSetting;

use App\Models\Activity;
use App\Models\ActivityTranslation;
use App\Models\ActivityProject;

use App\Models\ProjectEmployee;

use Dotenv\Exception\ValidationException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use Auth;
use Session;
use Carbon\Carbon;

class SettingController extends Controller
{



  public function settings()
    {
               if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        return view('website.home.settings');
    }

    ////////////////// Edit Office Profile ////////////////
    public function office_profile(Request $request)
    {    
     
               if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
        $item = User::findOrFail(Auth::user()->office_id);
        $cities =  City::where('country_id', $item->country_id)->get();
        $zones =  Zone::all();
            
        return view('website.settings.office_profile', [
            'item' => $item,
            'cities' => $cities,
            'zones' => $zones
            ]);
    }


    public function update_office_profile(Request $request)
    {
               if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
        $validator = Validator::make($request->all(), []);

        $rules = [
            'name' => "required",
            'mobile' => "required",
            'country_id' => "required",
            'city_id' => "required",
            'email' => 'required|email|unique:users,email,'.Auth::user()->office_id,
        ];

        $customMessages = [
            'required' => __('website.required_field'),
        ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        
        $item = User::findOrFail(Auth::user()->office_id);

        $item->name = $request->name;
        $item->country_id = $request->country_id;
        $item->city_id = $request->city_id;
        $item->address = $request->address;
        $item->mobile = $request->mobile; 
        $item->zone_id = $request->zone_id;
        $item->email = $request->email;

        if(isset($request->file)){
            $file = $request->file;
            $extension = $file->getClientOriginalExtension();
            $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'pro.' .$extension;
            $destinationPath = 'uploads/images/users';
            $file->move($destinationPath,$filename);
            $item->image = $filename;
        }

        $item->save();

        Session::flash('msg', __('website.data_updated'));
        return redirect('/office_profile');
    }
    
    ////////////////// End Edit Office Profile ////////////////





    ////////////////// Edit Profile ////////////////
    public function profile(Request $request)
        {
                   if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
            $item = User::findOrFail(Auth::user()->id);
            $cities =  City::where('country_id', $item->country_id)->get();
            $zones =  Zone::all();
              
            return view('website.settings.profile', [
                'item' => $item,
                'cities' => $cities,
                'zones' => $zones
                ]);
        }
    
  
  
    public function update_profile(Request $request)
    {
               if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
        $validator = Validator::make($request->all(), []);
  
        $rules = [
            'name' => "required",
            'mobile' => "required",
            'country_id' => "required",
            'city_id' => "required",
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
          ];
  
          $customMessages = [
              'required' => __('website.required_field'),
          ];
  
          $this->validate($request, $rules, $customMessages);
  
          if ($validator->fails()) {
              return back()->withErrors($validator)->withInput();
          }
  
          
          $item = User::findOrFail(Auth::user()->id);
  
          $item->name = $request->name;
          $item->country_id = $request->country_id;
          $item->city_id = $request->city_id;
          $item->address = $request->address;
          $item->mobile = $request->mobile; 
          $item->email = $request->email;
     
          if(isset($request->file)){
            $file = $request->file;
            $extension = $file->getClientOriginalExtension();
            $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'pro.' .$extension;
            $destinationPath = 'uploads/images/users';
            $file->move($destinationPath,$filename);
            $item->image = $filename;
          }
  
          $item->save();
  
  
          Session::flash('msg', __('website.data_updated'));
          return redirect('/profile');
    }
   
    ////////////////// End Edit Office Profile ////////////////
  



    ////////////////// Edit Clients Settings ////////////////
    public function clients_settings(Request $request)
        {  
                   if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
            return view('website.settings.clients_settings');
        }
    
       
       
       
    public function update_clients_settings(Request $request)
        {
                   if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
            $validator = Validator::make($request->all(), []);
       
            $rules = [
                'clients_number' => "required",       
            ];
       
            $customMessages = [
                'required' => __('website.required_field'),
            ];
       
            $this->validate($request, $rules, $customMessages);
       
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
       
            

            $offices_settings = OfficeSetting::updateOrCreate([
                'office_id' => Auth::user()->office_id
            ], [
                'clients_number' => $request->clients_number,
            ]);   
       
            Session::flash('msg', __('website.data_updated'));
            return redirect('/clients_settings');
        }
    
    ////////////////// End Edit Clients Settings ////////////////


           
    ////////////////// Edit Project Settings ////////////////
    public function projects_settings(Request $request)
        {       

       if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
            $offices_lawsuits = OfficeLawsuit::where('office_id', Auth::user()->office_id)->pluck('lawsuit_id')->toArray();              
            $offices_contenders = OfficeContender::where('office_id', Auth::user()->office_id)->pluck('contender_id')->toArray();
            $offices_consultations = OfficeConsultation::where('office_id', Auth::user()->office_id)->pluck('consultation_id')->toArray();

            $all_lawsuits  = Lawsuit::where('status', 'active')->get();
            $all_contenders  = Contender::where('status', 'active')->get();
            $all_consultations  = Consultation::where('status', 'active')->get();

            return view('website.settings.projects_settings', [
                'offices_lawsuits' => $offices_lawsuits,    
                'offices_contenders' => $offices_contenders,
                'offices_consultations' => $offices_consultations,
                'all_lawsuits' => $all_lawsuits,
                'all_contenders' => $all_contenders,
                'all_consultations' => $all_consultations,
                ]);
        }
    
       
       
       
    public function update_projects_settings(Request $request)
        {
                   if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
            if(isset($request->projects_number)){
                $office_settings = OfficeSetting::updateOrCreate([
                    'office_id' => Auth::user()->office_id
                ], [
                    'projects_number' => $request->projects_number,
                ]);  
            }



            OfficeLawsuit::where('office_id', Auth::user()->office_id)->delete();

            if(isset($request->offices_lawsuits)){
                foreach($request->offices_lawsuits as $i => $value){
                    $offices_lawsuits[] = [
                        'office_id' => Auth::user()->office_id,
                        'lawsuit_id' => $request->offices_lawsuits[$i]
                    ];
                }
                isset($offices_lawsuits)? OfficeLawsuit::insert($offices_lawsuits) : '';
            }



            OfficeContender::where('office_id', Auth::user()->office_id)->delete();

            if(isset($request->offices_contenders)){
                foreach($request->offices_contenders as $i => $value){
                    $offices_contenders[] = [
                        'office_id' => Auth::user()->office_id,
                        'contender_id' => $request->offices_contenders[$i]
                    ];
                }
                isset($offices_contenders)? OfficeContender::insert($offices_contenders) : '';
            }



            OfficeConsultation::where('office_id', Auth::user()->office_id)->delete();
            
            if(isset($request->offices_consultations)){
                foreach($request->offices_consultations as $i => $value){
                    $offices_consultations[] = [
                        'office_id' => Auth::user()->office_id,
                        'consultation_id' => $request->offices_consultations[$i]
                    ];
                }
                isset($offices_consultations)? OfficeConsultation::insert($offices_consultations) : '';
            }

            Session::flash('msg', __('website.data_updated'));
            return redirect('/projects_settings');
        }
    ////////////////// End Edit Project Settings ////////////////




    ////////////////// Edit Tasks Settings ////////////////
    public function tasks_settings(Request $request)
    {       

       if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
        $office_task_types = OfficeTaskType::where('office_id', Auth::user()->office_id)->pluck('task_type_id')->toArray();              
        $office_task_status = OfficeTaskStatus::where('office_id', Auth::user()->office_id)->pluck('task_status_id')->toArray();

        $all_task_types  = TaskType::where('status', 'active')->get();
        $all_task_status  = TaskStatus::where('status', 'active')->get();

        return view('website.settings.tasks_settings', [
            'office_task_types' => $office_task_types,    
            'office_task_status' => $office_task_status,
            'all_task_types' => $all_task_types,
            'all_task_status' => $all_task_status,
            ]);
    }



    public function update_tasks_settings(Request $request)
    {
     
            if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
        OfficeTaskType::where('office_id', Auth::user()->office_id)->delete();

        if(isset($request->office_task_types)){
            foreach($request->office_task_types as $i => $value){
                $office_task_types[] = [
                    'office_id' => Auth::user()->office_id,
                    'task_type_id' => $request->office_task_types[$i]
                ];
            }
            isset($office_task_types)? OfficeTaskType::insert($office_task_types) : '';
        }



        OfficeTaskStatus::where('office_id', Auth::user()->office_id)->delete();

        if(isset($request->office_task_status)){
            foreach($request->office_task_status as $i => $value){
                $office_task_status[] = [
                    'office_id' => Auth::user()->office_id,
                    'task_status_id' => $request->office_task_status[$i]
                ];
            }
            isset($office_task_status)? OfficeTaskStatus::insert($office_task_status    ) : '';
        }


        Session::flash('msg', __('website.data_updated'));
        return redirect('/tasks_settings');
    }
    ////////////////// End Edit Tasks Settings ////////////////






    ////////////////// Edit Clients Settings ////////////////
        public function hours_settings(Request $request)
            {  
                       if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
                $item = OfficeSetting::where('office_id', Auth::user()->office_id)->first();
                return view('website.settings.hours_settings', ['item' => $item]);
            }
    
       
       
       
    public function update_hours_settings(Request $request)
        {
                   if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
            $validator = Validator::make($request->all(), []);
       
            $rules = [
                'hour_price' => "required",       
            ];
       
            $customMessages = [
                'required' => __('website.required_field'),
            ];
       
            $this->validate($request, $rules, $customMessages);
       
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }


            $offices_settings = OfficeSetting::updateOrCreate([
                'office_id' => Auth::user()->office_id
            ], [
                'hour_price' => $request->hour_price,
            ]);  
            
       
            Session::flash('msg', __('website.data_updated'));
            return redirect('/hours_settings');
        }
    
    ////////////////// End Edit Clients Settings ////////////////





    ////////////////// Edit Invoices Settings ////////////////
    
      public function invoices_settings(Request $request)
      {       

       if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
          $office_discount_types = OfficeDiscountType::where('office_id', Auth::user()->office_id)->pluck('discount_type_id')->toArray();              
          $office_invoice_outputs = OfficeInvoiceOutput::where('office_id', Auth::user()->office_id)->pluck('invoice_output_id')->toArray();
          $office_payment_methods = OfficePaymentMethod::where('office_id', Auth::user()->office_id)->pluck('payment_method_id')->toArray();

          $all_discount_types  = DiscountType::where('status', 'active')->get();
          $all_invoice_outputs  = InvoiceOutput::where('status', 'active')->get();
          $all_payment_methods  = PaymentMethod::where('status', 'active')->get();

          return view('website.settings.invoices_settings', [
              'office_discount_types' => $office_discount_types,    
              'office_invoice_outputs' => $office_invoice_outputs,
              'office_payment_methods' => $office_payment_methods,
              'all_discount_types' => $all_discount_types,
              'all_invoice_outputs' => $all_invoice_outputs,
              'all_payment_methods' => $all_payment_methods,
              ]);
      }
  
     
     
     
  public function update_invoices_settings(Request $request)
      {

       if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
        $office_settings = OfficeSetting::updateOrCreate(['office_id' => Auth::user()->office_id], 
        ['invoices_number' => $request->invoices_number, 'office_vat' => $request->office_vat]);  
          

        OfficeDiscountType::where('office_id', Auth::user()->office_id)->delete();

          if(isset($request->office_discount_types)){
              foreach($request->office_discount_types as $i => $value){
                  $office_discount_types[] = [
                      'office_id' => Auth::user()->office_id,
                      'discount_type_id' => $request->office_discount_types[$i]
                  ];
              }
              isset($office_discount_types)? OfficeDiscountType::insert($office_discount_types) : '';
          }



          OfficePaymentMethod::where('office_id', Auth::user()->office_id)->delete();

          if(isset($request->office_payment_methods)){
              foreach($request->office_payment_methods as $i => $value){
                  $office_payment_methods[] = [
                      'office_id' => Auth::user()->office_id,
                      'payment_method_id' => $request->office_payment_methods[$i]
                  ];
              }
              isset($office_payment_methods)? OfficePaymentMethod::insert($office_payment_methods) : '';
          }



          Bank::where('office_id', Auth::user()->office_id)->delete();
          
          if(isset($request->bank_name)){
              foreach($request->bank_name as $i => $value){
                if(isset($request->bank_name[$i]) && isset($request->iban[$i])){
                  $banks[] = [
                      'office_id' => Auth::user()->office_id,
                      'name' => $request->bank_name[$i],
                      'iban' => $request->iban[$i]
                  ];
                }  
              }
              isset($banks)? Bank::insert($banks) : '';
          }

          Session::flash('msg', __('website.data_updated'));
          return redirect('/invoices_settings');
      }

    ////////////////// End Edit Invoices Settings ////////////////






        ////////////////// Edit Expense Settings ////////////////
    
        public function expenses_settings(Request $request)
        {       
  
         if(!user_role(9)){
            return redirect()->route('HomePage');
        } 
        
            $offices_aspect_expenses = OfficeAspectExpense::where('office_id', Auth::user()->office_id)->pluck('aspect_expense_id')->toArray();              
  
            $all_aspect_expenses  = AspectExpense::where('status', 'active')->get();
  
            return view('website.settings.expenses_settings', [
                'offices_aspect_expenses' => $offices_aspect_expenses,    
                'all_aspect_expenses' => $all_aspect_expenses,
                ]);
        }
    
       
       
       
    public function update_expenses_settings(Request $request)
        {
  
         if(!user_role(9)){
            return redirect()->route('HomePage');
        }           
  
            OfficeAspectExpense::where('office_id', Auth::user()->office_id)->delete();
  
            if(isset($request->offices_aspect_expenses)){
                foreach($request->offices_aspect_expenses as $i => $value){
                    $offices_aspect_expenses[] = [
                        'office_id' => Auth::user()->office_id,
                        'aspect_expense_id' => $request->offices_aspect_expenses[$i]
                    ];
                }
                isset($offices_aspect_expenses)? OfficeAspectExpense::insert($offices_aspect_expenses) : '';
            }
  
  


  
            Session::flash('msg', __('website.data_updated'));
            return redirect('/expenses_settings');
        }
  
      ////////////////// End Edit Expense Settings ////////////////


}
