<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

use App\Models\City;
use App\Models\CityTranslation;

use App\Models\Project;
use App\Models\ProjectHour;
use App\Models\Expense;

use App\Models\Task;

use App\Models\FlatFee;
use App\Models\InvoiceFlatFee;

use App\Models\Invoice;

use Carbon\Carbon;

use App\Models\Attachtype;
use App\Models\AttachtypeTranslation;
use App\Models\Language;
use App\Models\LanguageTranslation;
use App\Models\Attachment;
use App\Models\Client;
use App\Models\Role;
use App\Models\RoleTranslation;
use App\Models\Representative;
use App\Models\Card;
use App\Models\Note;

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

class ClientController extends Controller
{

    public function index(Request $request)
    {

        //return Hijri::DateShortFormat();


        $text = '';
        $items = Client::where('office_id', Auth::user()->office_id)->orderBy('client_number', 'desc')->get();
        return view('website.clients.home', ['items' => $items,'text' => $text,'cities' => City::all()]);
    }


    public function clientFilterStatus($status)
    {
        if($status == 'all'){
            $items = Client::where('office_id', Auth::user()->office_id)->orderBy('client_number', 'desc')->get();
        }

        else{
            $items = Client::where('office_id', Auth::user()->office_id)->where('status', $status)->orderBy('client_number', 'desc')->get();
        }

        $clientFilter = view('website.extraBlade.filters.clientFilter')->with(['clientFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'clientFilter' => $clientFilter ];
    }


    public function clientFilterText($text)
    {

        $items = Client::where('office_id', Auth::user()->office_id)->where('name', 'like', "%$text%")->orderBy('client_number', 'desc')->get();

        $clientFilter = view('website.extraBlade.filters.clientFilter')->with(['clientFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'clientFilter' => $clientFilter ];
    }



    public function clientFilterForm(Request $request)
    {

        $items = Client::where('office_id', Auth::user()->office_id);

        if(isset($request->country_id)){
            $items = $items->where(['country_id' => $request->country_id ,'city_id' => $request->city_id]);
        }

        if(isset($request->type)){
            $items = $items->where('type', $request->type);
        }

        $items = $items->orderBy('client_number', 'desc')->get();
        $clientFilter = view('website.extraBlade.filters.clientFilter')->with(['clientFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'clientFilter' => $clientFilter ];
    }



    public function create()
    {
        if(!user_role(1)){
            return redirect()->route('HomePage');
        }

        return view('website.clients.create', [
            'cities' => City::all(),
            'roles' => Role::all(),
            'attachtypes' => Attachtype::all(),
            'cards' => Card::all()]);
    }



    public function store(Request $request)
    {

        if(!user_role(1)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'person_name' => "required_if:type,1",  //type 1= Person 2= Company
            'person_country_id' => "required_if:type,1",
            'person_city_id' => "required_if:type,1",

            'company_name' => "required_if:type,2",
            'company_country_id' => "required_if:type,2",
            'company_city_id' => "required_if:type,2",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            'email' => __('website.enter_valid_email'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }


        $clients_count = Client::where('office_id', Auth::user()->office_id)->count();
        $client_number = str_pad($clients_count+1, 5, "0", STR_PAD_LEFT);


        $client = new Client();
        $client->office_id = Auth::user()->office_id;
        $client->type = $request->type;
        $client->name = $request->type == 1? $request->person_name: $request->company_name;
        $client->client_number = $client_number;
        $client->gender = $request->type == 1? $request->gender : null;
        $client->ID_number = $request->type == 1? $request->ID_number: null;
        $client->card_id = $request->type == 1? $request->card_id: null;
        $client->commercial_license = $request->type == 2? $request->commercial_license: null;
        $client->country_id = $request->type == 1? $request->person_country_id: $request->company_country_id;
        $client->city_id = $request->type == 1? $request->person_city_id: $request->company_city_id;
        $client->address = $request->type == 1? $request->person_address: $request->company_address;
        $client->phone = $request->type == 1? $request->person_phone: $request->company_phone;
        $client->mobile = $request->type == 1? $request->person_mobile: $request->company_mobile;
        $client->email = $request->type == 1? $request->person_email: $request->company_email;
        $client->notes = $request->notes;
        $client->status = ($request->has('status')? $request->status : 'active');
        $client->save();

        if(isset($request->rep_name)){
            foreach ($request->rep_name as $i => $value) {
                if(isset($request->rep_name[$i]) && isset($request->rep_address[$i]) && isset($request->rep_email[$i]) && isset($request->rep_mobile[$i]) && isset($request->rep_role_name[$i])){
                    $representative[] = [
                        'client_id' => $client->id,
                        'name' => $request->rep_name[$i],
                        'address' => $request->rep_address[$i],
                        'email' => $request->rep_email[$i],
                        'mobile' => $request->rep_mobile[$i],
                        'role_name' => $request->rep_role_name[$i],
                    ];
                }
            }
            isset($representative)? Representative::insert($representative) : '';
        }



        if(isset($request->attachment_name)){
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
                        'attachmentable_id' => $client->id,
                        'attachmentable_type' => "App\Models\Client",
                    ];
                }
            }
            isset($attachment)? Attachment::insert($attachment): '';
        }


        Session::flash('msg', __('website.data_added'));

        if(isset($request->saveway) && $request->saveway == 1){
            return redirect()->back();
        }
        else{
            return redirect('/clients');
        }

    }






    public function createModel(Request $request)
    {

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'person_name' => "required_if:type,1",  //type 1= Person 2= Company
            'person_country_id' => "required_if:type,1",
            'person_city_id' => "required_if:type,1",

            'company_name' => "required_if:type,2",
            'company_country_id' => "required_if:type,2",
            'company_city_id' => "required_if:type,2",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            'email' => __('website.enter_valid_email'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }


        $clients_count = Client::where('office_id', Auth::user()->office_id)->count();
        $client_number = str_pad($clients_count+1, 5, "0", STR_PAD_LEFT);


        $client = new Client();
        $client->office_id = Auth::user()->office_id;
        $client->type = $request->type;
        $client->name = $request->type == 1? $request->person_name: $request->company_name;
        $client->client_number = $client_number;
        $client->gender = $request->type == 1? $request->gender : null;
        $client->ID_number = $request->type == 1? $request->ID_number: null;
        $client->card_id = $request->type == 1? $request->card_id: null;
        $client->commercial_license = $request->type == 2? $request->commercial_license: null;
        $client->country_id = $request->type == 1? $request->person_country_id: $request->company_country_id;
        $client->city_id = $request->type == 1? $request->person_city_id: $request->company_city_id;
        $client->address = $request->type == 1? $request->person_address: $request->company_address;
        $client->phone = $request->type == 1? $request->person_phone: $request->company_phone;
        $client->mobile = $request->type == 1? $request->person_mobile: $request->company_mobile;
        $client->email = $request->type == 1? $request->person_email: $request->company_email;
        $client->notes = $request->notes;
        $client->status = ($request->has('status')? $request->status : 'active');
        $client->save();

            return $client;

    }




    public function show($id)
    {
        $item  = Client::findOrFail($id);
        return view('website.clients.clientDetails', [
            'item' => $item
        ]);
    }



    public function edit($id)
    {
        if(!user_role(1)){
            return redirect()->route('HomePage');
        }

        $roles            =  Role::all();
        $cards            =  Card::all();
        $attachtypes      =  Attachtype::all();
        $item             =  Client::findOrFail($id);
        $cities           =  City::where('country_id', $item->country_id)->get();
        return view('website.clients.edit', [
            'item' => $item ,
            'cities' => $cities,
            'cards' => $cards,
            'roles' => $roles,
            'attachtypes' => $attachtypes
        ]);
    }




    public function update(Request $request, $id)
    {
        if(!user_role(1)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'person_name' => "required_if:type,1",  //type 1= Person 2= Company
            'person_country_id' => "required_if:type,1",
            'person_city_id' => "required_if:type,1",

            'company_name' => "required_if:type,2",
            'company_country_id' => "required_if:type,2",
            'company_city_id' => "required_if:type,2",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            'email' => __('website.enter_valid_email'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }


        $client = Client::findOrFail($id);
        $client->office_id = Auth::user()->office_id;
        $client->type = $request->type;
        $client->name = $request->type == 1? $request->person_name: $request->company_name;
        $client->gender = $request->type == 1? $request->gender : null;
        $client->ID_number = $request->type == 1? $request->ID_number: null;
        $client->card_id = $request->type == 1? $request->card_id: null;
        $client->commercial_license = $request->type == 2? $request->commercial_license: null;
        $client->country_id = $request->type == 1? $request->person_country_id: $request->company_country_id;
        $client->city_id = $request->type == 1? $request->person_city_id: $request->company_city_id;
        $client->address = $request->type == 1? $request->person_address: $request->company_address;
        $client->phone = $request->type == 1? $request->person_phone: $request->company_phone;
        $client->mobile = $request->type == 1? $request->person_mobile: $request->company_mobile;
        $client->email = $request->type == 1? $request->person_email: $request->company_email;
        $client->notes = $request->notes;
        $client->status = $request->status;
        $client->save();


        /////////////////////////////// Representative /////////////////////////
        Representative::where('client_id', $id)->delete();

        foreach ($request->rep_name as $i => $value) {
            if(isset($request->rep_name[$i]) && isset($request->rep_address[$i]) && isset($request->rep_email[$i]) && isset($request->rep_mobile[$i]) && isset($request->rep_role_name[$i])){
                $representative[] = [
                    'client_id' => $client->id,
                    'name' => $request->rep_name[$i],
                    'address' => $request->rep_address[$i],
                    'email' => $request->rep_email[$i],
                    'mobile' => $request->rep_mobile[$i],
                    'role_name' => $request->rep_role_name[$i],
                ];
            }
        }
        isset($representative)? Representative::insert($representative) : '';




        //////////////////////////// Old Attach File ////////////////////////
        $attachments = Attachment::where('attachmentable_id', $id)->where('attachmentable_type', 'App\Models\Client')->get();

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
                    'attachmentable_id' => $client->id,
                    'attachmentable_type' => "App\Models\Client",
                ];
            }
        }
        isset($attachment)? Attachment::insert($attachment): '';


        Session::flash('msg', __('website.data_updated'));
        return redirect('/clients');
    }


    public function getClientProjects($id){
        return Project::where('client_id', $id)->get();
    }


    public function getProjectsTasks($id){
        return Task::where('project_id', $id)->get();
    }

    public function getClientInvoices($id){
        return Invoice::where('client_id', $id)->get();
    }


    public function getProjectHours($id){
        $projectHours = ProjectHour::where('project_id', $id)->get();
        $projectExpenses = Expense::where('project_id', $id)->get();
        $projectFlatsFees = FlatFee::where('project_id', $id)->get();

        $projectHours = view('website.extraBlade.invoices.projectHours')->with(['projectHours' => $projectHours])->render();
        $projectExpenses = view('website.extraBlade.invoices.projectExpenses')->with(['projectExpenses' => $projectExpenses])->render();
        $projectFlatsFees = view('website.extraBlade.invoices.projectFlatsFees')->with(['projectFlatsFees' => $projectFlatsFees])->render();


        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectFlatsFees' => $projectFlatsFees, 'projectHours' => $projectHours, 'projectExpenses' => $projectExpenses ];
    }



    public function getProjectHoExTa($id){
        $projectHours = ProjectHour::where('project_id', $id)->get();
        $projectExpenses = Expense::where('project_id', $id)->get();
        $projectTasks = Task::where('project_id', $id)->get();

        $projectHours = view('website.extraBlade.reports.projectHours')->with(['projectHours' => $projectHours])->render();
        $projectExpenses = view('website.extraBlade.reports.projectExpenses')->with(['projectExpenses' => $projectExpenses])->render();
        $projectTasks = view('website.extraBlade.reports.projectTasks')->with(['projectTasks' => $projectTasks])->render();

        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'),  'projectHours' => $projectHours, 'projectExpenses' => $projectExpenses, 'projectTasks' => $projectTasks ];
    }



    public function destroy($id)
    {

    }
}
