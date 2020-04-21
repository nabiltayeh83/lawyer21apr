<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\User;

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
use App\Models\ProjectHour;
use App\Models\OfficeSetting;
use Illuminate\Support\Arr;


use Dotenv\Exception\ValidationException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use PDF;


use App\Models\Activity;
use App\Models\ActivityTranslation;
use App\Models\ActivityProject;

use Auth;
use Session;

class ProjectHourController extends Controller
{

    public function index(Request $request)
    {
        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        $items = ProjectHour::where('office_id', Auth::user()->office_id)->orderBy('start_date', 'asc')->get();
        return view('website.hours.home', ['items' => $items]);
    }


    public function hourFilterStatus($status)
    {

        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        if($status == 'all'){
            $items = ProjectHour::where('office_id', Auth::user()->office_id)->orderBy('start_date', 'asc')->get();
        }

        if($status == 'thisWeek'){
            $today = Carbon::now()->addDays(7);
            $items = ProjectHour::where('office_id', Auth::user()->office_id)->whereBetween('start_date', [Carbon::now(), $today])->orderBy('start_date', 'asc')->get();
        }

        if($status == 'thisMonth'){
            $items = ProjectHour::where('office_id', Auth::user()->office_id)->whereMonth('start_date', Carbon::now()->month)->orderBy('start_date', 'asc')->get();
        }

        $hourFilter = view('website.extraBlade.filters.hourFilter')->with(['hourFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'hourFilter' => $hourFilter ];
    }


    public function hourFilterText($text)
    {

        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        $items = ProjectHour::where('office_id', Auth::user()->office_id)->where('hour_details', 'like', "%$text%")->orderBy('start_date', 'asc')->get();

        $hourFilter = view('website.extraBlade.filters.hourFilter')->with(['hourFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'hourFilter' => $hourFilter ];
    }


    public function hourFilterForm(Request $request)
    {

        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        $items = ProjectHour::where('office_id', Auth::user()->office_id);

         $project_id = $request->project_id;
         $task_id = $request->task_id;
         $responsible_lawyer = $request->responsible_lawyer;
         $hour_status = $request->hour_status;

            if(isset($request->task_id)){
                $items->where('task_id', $task_id);
            }

            if(isset($project_id)){
                $items->where('project_id', $project_id);
            }

            if(isset($responsible_lawyer)){
                $items->where('responsible_lawyer', $responsible_lawyer);
            }

            if(isset($hour_status)){
                $items->where('hour_status', $hour_status);
            }

            if(isset($request->date_from) and isset($request->date_to)){
                $date_from = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_from)));
                $date_to = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_to)));
                 $items->whereBetween('start_date', [$date_from, $date_to]);
             }

        $items = $items->orderBy('start_date', 'asc')->get();

        $hourFilter = view('website.extraBlade.filters.hourFilter')->with(['hourFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'hourFilter' => $hourFilter ];
    }


    public function create()
    {
        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        return view('website.hours.create');
    }



    public function store(Request $request)
    {

        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'responsible_lawyer' => "required",
            'hours_count' => "required",
            'start_date' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if(isset($request->start_date)){
            if(date("Y", strtotime($request->start_date)) == '1970'){
                $start_date = Arr::get(getDates($request->start_date), 'gregorian_date');
                $start_date_hijri = Arr::get(getDates($request->start_date), 'hijri_date');
            }
            else{
                $start_date = Arr::get(getDates(date("Y-m-d", strtotime($request->start_date))), 'gregorian_date');
                $start_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->start_date))), 'hijri_date');
                $start_date_hijri = convertAr2En($start_date_hijri);
            }
        }


        $project_hour = new ProjectHour();
        $project_hour->client_id = $request->client_id;
        $project_hour->office_id = Auth::user()->office_id;

        if(isset($request->task_id)){
            $project_hour->task_id = $request->task_id;
        }

        if(isset($request->project_id)){
            $project_hour->project_id = $request->project_id;
            $activities_projects = new ActivityProject();
            $activities_projects->office_id = Auth::user()->office_id;
            $activities_projects->action_user_id = Auth::user()->id;
            $activities_projects->activity_id = 3;
            $activities_projects->project_id = $request->project_id;
            $activities_projects->save();

            $project = Project::findOrFail($request->project_id);
            $project_hour->client_id = $project->client_id;
        }


        // if(isset($request->task_id) && !isset($request->project_id)){

        //     $task = Task::where('id', $request->task_id)->first();
        //     $project_id = $task->project_id;

        //     if(isset($project_id)){

        //         $project_hour->project_id = $project_id;

        //         $activities_projects = new ActivityProject();
        //         $activities_projects->office_id = Auth::user()->office_id;
        //         $activities_projects->action_user_id = Auth::user()->id;
        //         $activities_projects->activity_id = 3;
        //         $activities_projects->project_id = $project_id;
        //         $activities_projects->save();

        //         $project = Project::findOrFail($project_id);
        //         $project_hour->client_id = $project->client_id;
        //     }
        // }

        $project_hour->responsible_lawyer = $request->responsible_lawyer;
        $project_hour->hours_count = $request->hours_count;
        $project_hour->price = $request->price;
        $project_hour->start_date = $start_date;
        $project_hour->start_date_hijri	 = $start_date_hijri;
        $project_hour->hour_details = $request->hour_details;
        $project_hour->hour_office_details = $request->hour_office_details;
        $project_hour->save();

        return redirect('/hours');
    }




    public function InvoiceHour(Request $request)
    {

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'responsible_lawyer' => "required",
            'hours_count' => "required",
            'start_date' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        $project_hour = new ProjectHour();
        $project_hour->office_id = Auth::user()->office_id;

        if($request->task_id){
            $project_hour->task_id = $request->task_id;
        }

        if($request->project_id){
            $project_hour->project_id = $request->project_id;

            $activities_projects = new ActivityProject();
            $activities_projects->office_id = Auth::user()->office_id;
            $activities_projects->action_user_id = Auth::user()->id;
            $activities_projects->activity_id = 3;
            $activities_projects->project_id = $request->project_id;
            $activities_projects->save();

            $project = Project::findOrFail($request->project_id);
            $project_hour->client_id = $project->client_id;
        }


        if($request->task_id && !$request->project_id){

            $task = Task::where('id', $request->task_id)->first();
            $project_id = $task->project_id;

            if(isset($project_id)){

                $project_hour->project_id = $project_id;

                $activities_projects = new ActivityProject();
                $activities_projects->office_id = Auth::user()->office_id;
                $activities_projects->action_user_id = Auth::user()->id;
                $activities_projects->activity_id = 3;
                $activities_projects->project_id = $project_id;
                $activities_projects->save();


                $project = Project::findOrFail($project_id);
                $project_hour->client_id = $project->client_id;
            }
        }



        $project_hour->responsible_lawyer = $request->responsible_lawyer;
        $project_hour->hours_count = $request->hours_count;
        $project_hour->price = $request->price;
        $project_hour->start_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
        $project_hour->hour_details = $request->hour_details;
        $project_hour->hour_office_details = $request->hour_office_details;
        $project_hour->save();

        $projectHours = view('website.extraBlade.invoices.newProjectHours')->with(['projectHours' => $project_hour])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectHours' => $projectHours ];

    }





    public function ReportHours(Request $request)
    {

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'responsible_lawyer' => "required",
            'hours_count' => "required",
            'start_date' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        $project_hour = new ProjectHour();
        $project_hour->office_id = Auth::user()->office_id;

        if($request->task_id){
            $project_hour->task_id = $request->task_id;
        }

        if($request->project_id){
            $project_hour->project_id = $request->project_id;

            $activities_projects = new ActivityProject();
            $activities_projects->office_id = Auth::user()->office_id;
            $activities_projects->action_user_id = Auth::user()->id;
            $activities_projects->activity_id = 3;
            $activities_projects->project_id = $request->project_id;
            $activities_projects->save();

            $project = Project::findOrFail($request->project_id);
            $project_hour->client_id = $project->client_id;
        }


        if($request->task_id && !$request->project_id){

            $task = Task::where('id', $request->task_id)->first();
            $project_id = $task->project_id;

            if(isset($project_id)){

                $project_hour->project_id = $project_id;

                $activities_projects = new ActivityProject();
                $activities_projects->office_id = Auth::user()->office_id;
                $activities_projects->action_user_id = Auth::user()->id;
                $activities_projects->activity_id = 3;
                $activities_projects->project_id = $project_id;
                $activities_projects->save();


                $project = Project::findOrFail($project_id);
                $project_hour->client_id = $project->client_id;
            }
        }



        $project_hour->responsible_lawyer = $request->responsible_lawyer;
        $project_hour->hours_count = $request->hours_count;
        $project_hour->price = $request->price;
        $project_hour->start_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
        $project_hour->hour_details = $request->hour_details;
        $project_hour->hour_office_details = $request->hour_office_details;
        $project_hour->save();

        $projectHours = view('website.extraBlade.reports.newProjectHours')->with(['projectHours' => $project_hour])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectHours' => $projectHours ];

    }





    public function show($id)
    {
        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        $item  = ProjectHour::findOrFail($id);
        return view('website.hours.hourDetails', ['item' => $item]);
    }



    public function create_note(Request $request)
    {
        $note = new Note();
        $note->client_id = $request->client_id;
        $note->note = $request->note;
        $note->note_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->note_date)));
        $note->save();
        return back();
    }




    public function delete_note($id)
    {
        $note = Note::findOrFail($id);

        if($note){
            $note->delete();
        }
    }



    public function completeTask($task_id)
    {
        $item  = Task::findOrFail($task_id);
        $item->task_status_id = 4;
        $item->save();
    }



    public function exportAllHoursPDF(){

        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        $hours = ProjectHour::where('office_id', Auth::user()->office_id)->get();

        $data =
        [
           'hours' => $hours,
           'logo' => 'assets/img/logo.svg',
           'signature' => 'assets/img/signature2x.png',

        ];

        $pdf = PDF::loadView('website.hours.exportAllHoursPDF', $data);
        return $pdf->stream('hours.pdf');
     }



    public function changeTaskStatus($task_id, $newStatus)
    {
        $item  = Task::findOrFail($task_id);
        $item->task_status_id = $newStatus;
        $item->save();
    }




    public function edit($id)
    {

        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        $item = ProjectHour::findOrFail($id);
        return view('website.hours.edit', [
            'item' => $item,
            'project_tasks' => Task::where('project_id', $item->project_id)->get(),
        ]
    );
    }



    public function update(Request $request, $id)
    {

        if(!user_role(4)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'project_id' => "required",
            'task_id' => "required",
            'responsible_lawyer' => "required",
            'hours_count' => "required",
            'price' => "required",
            'start_date' => "required",
            'hour_details' => "required",
            'hour_office_details' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        
        if(isset($request->start_date)){
            if(date("Y", strtotime($request->start_date)) == '1970'){
                $start_date = Arr::get(getDates($request->start_date), 'gregorian_date');
                $start_date_hijri = Arr::get(getDates($request->start_date), 'hijri_date');
            }
            else{
                $start_date = Arr::get(getDates(date("Y-m-d", strtotime($request->start_date))), 'gregorian_date');
                $start_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->start_date))), 'hijri_date');
                $start_date_hijri = convertAr2En($start_date_hijri);
            }
        }

        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $project_hour = ProjectHour::findOrFail($id);

        $project_hour->project_id = $request->project_id;
        $project_hour->task_id = $request->task_id;
        $project_hour->responsible_lawyer = $request->responsible_lawyer;
        $project_hour->hours_count = $request->hours_count;
        $project_hour->price = $request->price;
        $project_hour->start_date = $start_date;
        $project_hour->start_date_hijri	 = $start_date_hijri;
        $project_hour->hour_details = $request->hour_details;
        $project_hour->hour_office_details = $request->hour_office_details;

        $project_hour->save();
        return redirect('/hours');

    }


    public function destroy($id)
    {

    }

}
