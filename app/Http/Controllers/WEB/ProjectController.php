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
use Illuminate\Support\Arr;

use PDF;

use App\Models\ClientDescription;
use App\Models\ClientDescriptionTranslation;
use App\Models\Attachtype;
use App\Models\AttachtypeTranslation;
use App\Models\Language;
use App\Models\LanguageTranslation;
use App\Models\Role;
use App\Models\RoleTranslation;

use App\Models\FlatFee;

use App\Models\Projectstatus;
use App\Models\ProjectstatusTranslation;

use App\Models\Representative;
use App\Models\Client;
use App\Models\Attachment;
use App\Models\Card;
use App\Models\Project;
use App\Models\Note;

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

class ProjectController extends Controller
{


    public function index(Request $request)
    {
        $items = Project::where('office_id', Auth::user()->office_id)->latest()->get();
        return view('website.projects.home', ['items' => $items]);
    }


    public function projectFilterStatus($status)
    {
        if($status == 'all'){
            $items = Project::where('office_id', Auth::user()->office_id)->latest()->get();
        }else{
            $items = Project::where('office_id', Auth::user()->office_id)->where('project_status_id', $status)->latest()->get();
        }

        $projectFilter = view('website.extraBlade.filters.projectFilter')->with(['projectFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectFilter' => $projectFilter ];
    }


    public function projectFilterText($text)
    {
        $items = Project::where('office_id', Auth::user()->office_id)->where('name', 'like', "%$text%")->latest()->get();

        $projectFilter = view('website.extraBlade.filters.projectFilter')->with(['projectFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectFilter' => $projectFilter ];
    }


    public function projectFilterForm(Request $request)
    {

        $items = Project::where('office_id', Auth::user()->office_id);

        if(isset($request->client_id)){
            $items->where('client_id', $request->client_id);
        }

        if(isset($request->responsible_lawyer)){
            $items->where('responsible_lawyer', $request->responsible_lawyer);
        }

        if(isset($request->type)){
            $items->where('type', $request->type);
        }


        if(isset($request->start_date) && isset($request->end_date)){
            $start_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
            $end_date   = date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date)));
            $items->whereDate('created_at','>=',$start_date)->whereDate('created_at','<=',$end_date);
        }

        $items = $items->latest()->get();

        $projectFilter = view('website.extraBlade.filters.projectFilter')->with(['projectFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectFilter' => $projectFilter ];
    }





    public function create(Request $request)
    {
        if(!user_role(2)){
            return redirect()->route('HomePage');
        }

        return view('website.projects.create', [
            'client_id' => $request->client_id,
            'attachtypes' => Attachtype::all(),
            'cities' => City::all(),
            'clients_descriptions' => ClientDescription::all(),
            'roles' => Role::all(),
            'attachtypes' => Attachtype::all(),
            'cards' => Card::all(),
        ]);
    }



    public function store(Request $request)
    {
        

        if(!user_role(2)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');

        $validator = Validator::make($request->all(), []);

        $rules = [
            'case_client_id' => "required_if:type,1", //'issue 1','consultation 2','other 3'
            'case_name' => "required_if:type,1",
            'case_fee_type' => "required_if:type,1",
            'case_lawsuit_id' => "required_if:type,1",
            'case_project_status' => "required_if:type,1",

            'consultation_client_id' => "required_if:type,2",
            'consultation_name' => "required_if:type,2",
            'consultation_consultation_id' => "required_if:type,2",
            'consultation_status' => "required_if:type,2",

            'other_name' => "required_if:type,3",
            'other_status' => "required_if:type,3",
            'other_responsible_lawyer' => "required_if:type,3",
        ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            'email' => __('website.enter_valid_email'),
        ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        if(isset($request->start_project_date)){
            if(date("Y", strtotime($request->start_project_date)) == '1970'){
                $start_project_date = Arr::get(getDates($request->start_project_date), 'gregorian_date');
                $start_project_date_hijri = Arr::get(getDates($request->start_project_date), 'hijri_date');
            }
            else{
                $start_project_date = Arr::get(getDates(date("Y-m-d", strtotime($request->start_project_date))), 'gregorian_date');
                $start_project_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->start_project_date))), 'hijri_date');
                $start_project_date_hijri = convertAr2En($start_project_date_hijri);
            }
        }



        $projects_count = Project::where('office_id', Auth::user()->office_id)->count();
        $project_number = str_pad($projects_count+1, 5, "0", STR_PAD_LEFT);


        $project = new Project();
        $project->office_id = Auth::user()->office_id;
        $project->type = $request->type;

        if(isset($request->type) && $request->type == 1){ //New Issue
            $project->client_id        =  $request->case_client_id;
            $project->name             =  $request->case_name;
            $project->client_description_id	 = $request->client_description_id;
            $project->case_name  = $request->case_name;
            $project->project_number   =  $project_number;
            $project->reference_number  =  $request->case_reference_number;
            $project->project_status_id   =  $request->case_project_status;
            $project->details          =  $request->case_details;
            $project->value_per_hour   =  $request->case_value_per_hour;
            $project->fee_type         =  $request->case_fee_type;
            $project->lawsuit_id       =  $request->case_lawsuit_id;
            $project->start_project_date =  $start_project_date;
            $project->start_project_date_hijri = $start_project_date_hijri;

            $project->gov_institution  =  $request->case_gov_institution;
            $project->contender_id = $request->contender_id;
            $project->contender_name = $request->contender_name;
            $project->contender_address = $request->contender_address;
            $project->responsible_lawyer = $request->responsible_lawyer;
            $project->court_name = $request->court_name;

        }




        if(isset($request->type) && $request->type == 2){ //New Consultation
            $project->client_id        =  $request->consultation_client_id;
            $project->name             =  $request->consultation_name;
            $project->project_number   =  $project_number;
            $project->reference_number  =  $request->consultation_reference_number;
            $project->consultation_id  =  $request->consultation_consultation_id;
            $project->project_status_id   =  $request->consultation_status;
            $project->details          =  $request->consultation_details;
            $project->fee_type         =  $request->consultation_fee_type;
            $project->value_per_hour   =  $request->consultation_value_per_hour;
            $project->responsible_lawyer = $request->consultation_responsible_lawyer;
        }

        if(isset($request->type) && $request->type == 3){ //New Other
            $project->client_id        =  $request->other_client_id;
            $project->name             =  $request->other_name;
            $project->project_number   =  $project_number;
            $project->reference_number  =  $request->other_reference_number;
            $project->details          =  $request->other_details;
            $project->project_status_id   =  $request->other_status;
            $project->responsible_lawyer = $request->other_responsible_lawyer;
        }

        $project->save();


        if(isset($request->extrafield)){
            foreach($request->extrafield as $key => $value){
                $extrafields[] = [
                    'project_id' => $project->id,
                    'field_id' => $request->fieldsids[$key],
                    'value' => $value
                ];
            }
        }
        isset($extrafields)? ProjectField::insert($extrafields) : '';


        if(isset($request->consultation_issue_fees) || isset($request->case_issue_fees)){
            $flats_fees = new FlatFee();
            $flats_fees->office_id = Auth::user()->office_id;
            $flats_fees->project_id = $project->id;
            $flats_fees->price = isset($request->consultation_issue_fees)? $request->consultation_issue_fees : $request->case_issue_fees;
            $flats_fees->save();
        }


        if(isset($request->project_employees)){
            foreach($request->project_employees as $i => $value){
                $employees[] = [
                    'project_id' => $project->id,
                    'user_id' => $request->project_employees[$i]
                ];
            }
            isset($employees)? ProjectEmployee::insert($employees) : '';
        }



        if(isset($request->attachment_name)){
            foreach ($request->attachment_name as $i => $value){
                if(isset($request->attachment_name[$i]) &&  isset($request->attachfile[$i])){
                    $file = $request->attachfile[$i];
                    $extension = $file->getClientOriginalExtension();
                    $filename  = "pro_".Auth::user()->user_id."_".time()."_".rand(1,50000). '.' .$extension;
                    $destinationPath = 'uploads/websitefiles/attachments';
                    $file->move($destinationPath,$filename);

                    $attachment[] = [
                        'attachment_name' => $request->attachment_name[$i],
                        'file' => $filename,
                        'attachmentable_id' => $project->id,
                        'attachmentable_type' => "App\Models\Project",
                    ];
                }
            }
            isset($attachment)? Attachment::insert($attachment): '';
        }

        $activities_projects = new ActivityProject();
        $activities_projects->office_id = Auth::user()->office_id;
        $activities_projects->action_user_id = Auth::user()->id;
        $activities_projects->activity_id = 1;
        $activities_projects->project_id = $project->id;
        $activities_projects->save();

        Session::flash('msg', __('website.data_added'));

        if(isset($request->saveway) && $request->saveway == 1){
            return redirect()->back();
        }
        else{
            return redirect('/projects');
        }

    }



    public function show($id)
    {
        $item  = Project::findOrFail($id);
        $project_tasks = Task::where('project_id', $id)->get();
        return view('website.projects.projectDetails', ['item' => $item, 'project_tasks' => $project_tasks]);
    }



    public function changeStatus($project_id, $newStatus)
    {
        $item  = Project::findOrFail($project_id);
        $item->project_status_id = $newStatus;
        $item->save();

        $activities_projects = new ActivityProject();
        $activities_projects->office_id = Auth::user()->office_id;
        $activities_projects->action_user_id = Auth::user()->id;
        $activities_projects->activity_id = 9;
        $activities_projects->project_id = $project_id;
        $activities_projects->save();

    }





    public function edit($id)
    {

        if(!user_role(2)){
            return redirect()->route('HomePage');
        }

        $item = Project::findOrFail($id);

        $project_employees = ProjectEmployee::where('project_id', $id)->pluck('user_id')->toArray();

        return view('website.projects.edit', [
            'item' => $item,
            'attachtypes' => Attachtype::all(),
            'clients_descriptions' => ClientDescription::all(),
            'project_employees' => $project_employees,
        ]);

    }





    public function update(Request $request, $id)
    {

        if(!user_role(2)){
            return redirect()->route('HomePage');
        }


        $validator = Validator::make($request->all(), []);

        $rules = [
            'case_client_id' => "required_if:type,1", //'issue 1','consultation 2','other 3'
            'case_name' => "required_if:type,1",
            'case_fee_type' => "required_if:type,1",
            'case_lawsuit_id' => "required_if:type,1",
            'case_project_status' => "required_if:type,1",

            'consultation_client_id' => "required_if:type,2",
            'consultation_name' => "required_if:type,2",
            'consultation_consultation_id' => "required_if:type,2",
            'consultation_status' => "required_if:type,2",

            'other_name' => "required_if:type,3",
            'other_status' => "required_if:type,3",
            'other_responsible_lawyer' => "required_if:type,3",
        ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            'email' => __('website.enter_valid_email'),
        ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if(isset($request->start_project_date)){
            if(date("Y", strtotime($request->start_project_date)) == '1970'){
                $start_project_date = Arr::get(getDates($request->start_project_date), 'gregorian_date');
                $start_project_date_hijri = Arr::get(getDates($request->start_project_date), 'hijri_date');
            }
            else{
                $start_project_date = Arr::get(getDates(date("Y-m-d", strtotime($request->start_project_date))), 'gregorian_date');
                $start_project_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->start_project_date))), 'hijri_date');
                $start_project_date_hijri = convertAr2En($start_project_date_hijri);
            }
        }

        $locales = Language::all()->pluck('lang');
        $project = Project::findOrFail($id);

        $project->type = $request->type;

        if(isset($request->type) && $request->type == 1){ //New Issue
            $project->client_id        =  $request->case_client_id;
            $project->name             =  $request->case_name;
            $project->client_description_id	 = $request->client_description_id;
            $project->case_name  = $request->case_name;
            $project->reference_number  =  $request->case_reference_number;
            $project->project_status_id   =  $request->case_project_status;
            $project->details          =  $request->case_details;
            $project->value_per_hour   =  $request->case_value_per_hour;
            //$project->issue_fees       =  $request->case_issue_fees;
            //$project->fee_type         =  $request->case_fee_type;
            $project->lawsuit_id       =  $request->case_lawsuit_id;
            $project->start_project_date =  $start_project_date;
            $project->start_project_date_hijri = $start_project_date_hijri;

            $project->gov_institution  =  $request->case_gov_institution;
            $project->contender_id = $request->contender_id;
            $project->contender_name = $request->contender_name;
            $project->contender_address = $request->contender_address;
            $project->responsible_lawyer = $request->responsible_lawyer;
            $project->court_name = $request->court_name;

        }

        if(isset($request->type) && $request->type == 2){ //New Consultation
            $project->client_id        =  $request->consultation_client_id;
            $project->name             =  $request->consultation_name;
            $project->reference_number  =  $request->consultation_reference_number;
            $project->consultation_id  =  $request->consultation_consultation_id;
            $project->project_status_id   =  $request->consultation_status;
            $project->details          =  $request->consultation_details;
            $project->fee_type         =  $request->consultation_fee_type;
            $project->value_per_hour   =  $request->consultation_value_per_hour;
            $project->issue_fees       =  $request->consultation_issue_fees;
            $project->responsible_lawyer = $request->consultation_responsible_lawyer;

        }

        if(isset($request->type) && $request->type == 3){ //New Other
            $project->name             =  $request->other_name;
            $project->reference_number  =  $request->other_reference_number;
            $project->details          =  $request->other_details;
            $project->project_status_id   =  $request->other_status;
            $project->responsible_lawyer = $request->other_responsible_lawyer;
        }

        $project->save();


        ProjectField::where('project_id', $project->id)->delete();

        if(isset($request->extrafield)){
            foreach($request->extrafield as $key => $value){
                $extrafields[] = [
                    'project_id' => $project->id,
                    'field_id' => $request->fieldsids[$key],
                    'value' => $value
                ];
            }
        }
        isset($extrafields)? ProjectField::insert($extrafields) : '';



        ProjectEmployee::where('project_id', $project->id)->delete();

        if(isset($request->project_employees)){
            foreach($request->project_employees as $i => $value){
                $employees[] = [
                    'project_id' => $project->id,
                    'user_id' => $request->project_employees[$i]
                ];
            }
            isset($employees)? ProjectEmployee::insert($employees) : '';
        }


        //////////////////////////// Old Attach File ////////////////////////
        $attachments = Attachment::where('attachmentable_id', $id)->where('attachmentable_type', 'App\Models\Project')->get();


        if(isset($attachments)){

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

        }




        ///////////////////////////// New Attach File //////////////////////////

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
                        'attachmentable_id' => $project->id,
                        'attachmentable_type' => "App\Models\Project",
                    ];
                }
            }
            isset($attachment)? Attachment::insert($attachment): '';
        }


        $activities_projects = new ActivityProject();
        $activities_projects->office_id = Auth::user()->office_id;
        $activities_projects->action_user_id = Auth::user()->id;
        $activities_projects->activity_id = 2;
        $activities_projects->project_id = $project->id;
        $activities_projects->save();

        Session::flash('msg', __('website.data_updated'));
        return redirect('/projects');
    }



    public function exportAllProjectsPDF(){

        if(!user_role(2)){
            return redirect()->route('HomePage');
        }

        $projects = Project::where('office_id', Auth::user()->office_id)->get();

        $data =
        [
           'projects' => $projects,
           'logo' => 'assets/img/logo.svg',
           'signature' => 'assets/img/signature2x.png',

        ];

        $pdf = PDF::loadView('website.projects.exportAllProjectsPDF', $data);
        return $pdf->stream('projects.pdf');
     }



     public function exportProjectDetPDF($id){

        if(!user_role(2)){
            return redirect()->route('HomePage');
        }

        $item = Project::findOrFail($id);

        $data =
        [
           'item' => $item,
           'logo' => 'assets/img/logo.svg',
           'signature' => 'assets/img/signature2x.png',

        ];



        $pdf = PDF::loadView('website.projects.exportProjectDetPDF', $data);
        return $pdf->stream('project.pdf');
     }



    public function destroy($id)
    {

    }


}
