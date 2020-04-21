<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\User;

use Carbon\Carbon;

use App\Models\City;
use App\Models\CityTranslation;
use App\Models\Country;
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

use App\Models\TaskEmployee;
use Illuminate\Support\Arr;


use PDF;


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

class TaskController extends Controller
{


    public function index(Request $request)
    {
        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $items = Task::where('office_id', Auth::user()->office_id)->orderBy('end_date', 'asc')->get();
        return view('website.tasks.home', ['items' => $items]);
    }


    public function taskFilterStatus($status)
    {
        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        if($status == 'all'){
            $items = Task::where('office_id', Auth::user()->office_id)->orderBy('end_date', 'asc')->get();
        }

        else{
            $items = Task::where('office_id', Auth::user()->office_id)->where('priority', $status)->orderBy('end_date', 'asc')->get();
        }

        $taskFilter = view('website.extraBlade.filters.taskFilter')->with(['taskFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'taskFilter' => $taskFilter ];
    }


    public function taskFilterText($text)
    {
        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $items = Task::where('office_id', Auth::user()->office_id)->where('name', 'like', "%$text%")->orderBy('end_date', 'asc')->get();

        $taskFilter = view('website.extraBlade.filters.taskFilter')->with(['taskFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'taskFilter' => $taskFilter ];
    }


    public function taskFilterForm(Request $request)
    {

        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $items = Task::where('office_id', Auth::user()->office_id);
        $task_status_id = $request->task_status_id;
        $responsible_employee = $request->responsible_employee;
        $task_ended = $request->task_ended;


        if(isset($request->task_ended)){
            if(isset($task_ended) && $task_ended == 'today'){
                $items->whereDate('end_date', date("Y-m-d"));
            }
            if(isset($task_ended) && $task_ended == 'after_week'){
                $items->where('end_date', '>=', Carbon::now()->startOfWeek()->addDays(5))->where('end_date', '<=', Carbon::now()->endOfWeek()->addDays(4));
            }
        }

        if(isset($task_status_id)){
            $items->where('task_status_id', $task_status_id);
        }

        if(isset($responsible_employee)){
            $items->where('responsible_employee', $responsible_employee);
        }

        if(isset($request->from_date) and isset($request->to_date)){
            $from_date =  date("Y-m-d", strtotime(str_replace('/', '-', $request->from_date)));
            $to_date =  date("Y-m-d", strtotime(str_replace('/', '-', $request->to_date)));
            $items->whereBetween('end_date', [$from_date, $to_date]);
        }

        $items = $items->orderBy('end_date', 'asc')->get();

        $taskFilter = view('website.extraBlade.filters.taskFilter')->with(['taskFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'taskFilter' => $taskFilter ];
    }





    public function getTasksSame($date)
    {
        $date =  date("Y-m-d", strtotime($date));
        return Task::where('end_date', $date)->get();
    }



    public function create()
    {
        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        return view('website.tasks.create');
    }



    public function store(Request $request)
    {
        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'task_category' => "nullable",
            'project_id' => "required_if:task_category,project",
            'task_type_id' => "required",
            'task_status_id' => "required",
            'priority' => "required",
            'remind_type' => "required_if:remind,yes",
            'remind_time_id' => "required_if:remind,yes",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }


        if(isset($request->end_date)){
            if(date("Y", strtotime($request->end_date)) == '1970'){
                $end_date = Arr::get(getDates($request->end_date), 'gregorian_date');
                $end_date_hijri = Arr::get(getDates($request->end_date), 'hijri_date');
            }
            else{
                $end_date = Arr::get(getDates(date("Y-m-d", strtotime($request->end_date))), 'gregorian_date');
                $end_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->end_date))), 'hijri_date');
                $end_date_hijri = convertAr2En($end_date_hijri);
            }
        }


        $task = new Task();

        $task->office_id = Auth::user()->office_id;
        $task->name = $request->name;

        if(isset($request->task_category) && $request->task_category == 'project'){
            $task->project_id = $request->project_id;
            $task->task_category = 'project';
        }
        else{
            $task->project_id = $request->project_id;
            $task->task_category = 'other';
        }


        isset($request->task_category_id)? $task->task_category_id = $request->task_category_id : 'other';
        $task->task_type_id = $request->task_type_id;
        isset($request->details)? $task->details = $request->details : '';
        $task->task_status_id = $request->task_status_id;
        $task->priority = $request->priority;
        $task->end_date = $end_date;
        $task->end_date_hijri = $end_date_hijri;
        $task->task_time = $request->task_time;
        if(isset($request->remind)){
            $task->remind = $request->remind;
            $task->remind_type = $request->remind_type;
            $task->remind_time_id = $request->remind_time_id;
        }

        isset($request->responsible_employee)? $task->responsible_employee = $request->responsible_employee : '';
        $task->save();



        if(isset($request->task_employees)){
            foreach($request->task_employees as $i => $value){
                $employees[] = [
                    'task_id' => $task->id,
                    'user_id' => $request->task_employees[$i]
                ];
            }
            isset($employees)? TaskEmployee::insert($employees) : '';
        }


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
                    'attachmentable_id' => $task->id,
                    'attachmentable_type' => "App\Models\Task",
                ];
            }
        }
        isset($attachment)? Attachment::insert($attachment): '';
        }

        if($request->project_id){
            $activities_projects = new ActivityProject();
            $activities_projects->office_id = Auth::user()->office_id;
            $activities_projects->action_user_id = Auth::user()->id;
            $activities_projects->activity_id = 6;
            $activities_projects->project_id = $request->project_id;
            $activities_projects->save();
        }


        Session::flash('msg', __('website.data_added'));

        if(isset($request->saveway) && $request->saveway == 1){
            return redirect()->back();
        }
        else{
            return redirect('/tasks');
        }

    }



   public function ReportTasks(Request $request)
    {


        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'task_category' => "required",
            'project_id' => "required_if:task_category,project",
            'task_type_id' => "required",
            'task_status_id' => "required",
            'priority' => "required",
            'remind_type' => "required_if:remind,yes",
            'remind_time_id' => "required_if:remind,yes",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $task = new Task();

        $task->office_id = Auth::user()->office_id;
        $task->name = $request->name;

        if(isset($request->task_category) && $request->task_category == 'project'){
            $task->project_id = $request->project_id;
            $task->task_category = 'project';
        }
        else{
            $task->project_id = $request->project_id;
            $task->task_category = null;
        }

        isset($request->task_category_id)? $task->task_category_id = $request->task_category_id : '';
        $task->task_type_id = $request->task_type_id;
        isset($request->details)? $task->details = $request->details : '';
        $task->task_status_id = $request->task_status_id;
        $task->priority = $request->priority;
        $task->end_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date)));
        $task->task_time = $request->task_time;

        if(isset($request->remind)){
            $task->remind = $request->remind;
            $task->remind_type = $request->remind_type;
            $task->remind_time_id = $request->remind_time_id;
        }

        isset($request->responsible_employee)? $task->responsible_employee = $request->responsible_employee : '';
        $task->save();

        if(isset($request->task_employees)){
            foreach($request->task_employees as $i => $value){
                $employees[] = [
                    'task_id' => $task->id,
                    'user_id' => $request->task_employees[$i]
                ];
            }
            isset($employees)? TaskEmployee::insert($employees) : '';
        }

        $projectTasks = view('website.extraBlade.reports.newProjectTasks')->with(['projectTasks' => $task])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectTasks' => $projectTasks ];
    }




    public function show($id)
    {
        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $item  = Task::findOrFail($id);
        return view('website.tasks.taskDetails', ['item' => $item]);
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

        if(isset($note)){
            $note->delete();
        }

    }



    public function completeTask($task_id)
    {
        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $item  = Task::findOrFail($task_id);
        $item->task_status_id = 2;
        $item->save();
    }




    public function changeTaskStatus($task_id, $newStatus)
    {
        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $item  = Task::findOrFail($task_id);
        $item->task_status_id = $newStatus;
        $item->save();
    }


    public function edit($id)
    {
        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $item = Task::findOrFail($id);
        $task_employees = TaskEmployee::where('task_id', $id)->pluck('user_id')->toArray();
        return view('website.tasks.edit', ['item' => $item,'task_employees' => $task_employees]);
    }



    public function exportAllTasksPDF(){

        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $tasks = Task::where('office_id', Auth::user()->office_id)->get();

        $data =
        [
           'tasks' => $tasks,
           'logo' => 'assets/img/logo.svg',
           'signature' => 'assets/img/signature2x.png',

        ];

        $pdf = PDF::loadView('website.tasks.exportAllTasksPDF', $data);
        return $pdf->stream('tasks.pdf');
     }


    public function update(Request $request, $id)
    {

        if(!user_role(3)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'task_category' => "required",
            'project_id' => "required_if:task_category,project",
            'task_type_id' => "required",
            'task_status_id' => "required",
            'priority' => "required",
            'end_date' => "required",
            'remind_type' => "required_if:remind,yes",
            'remind_time_id' => "required_if:remind,yes",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        if(isset($request->end_date)){
            if(date("Y", strtotime($request->end_date)) == '1970'){
                $end_date = Arr::get(getDates($request->end_date), 'gregorian_date');
                $end_date_hijri = Arr::get(getDates($request->end_date), 'hijri_date');
            }
            else{
                $end_date = Arr::get(getDates(date("Y-m-d", strtotime($request->end_date))), 'gregorian_date');
                $end_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->end_date))), 'hijri_date');
                $end_date_hijri = convertAr2En($end_date_hijri);
            }
        }

        $task = Task::findOrFail($id);

        $task->name = $request->name;

        if(isset($request->task_category) && $request->task_category == 'project'){
            $task->project_id = $request->project_id;
            $task->task_category = 'project';
        }
        else{
            $task->task_category = 'other';
            $task->project_id = null;
        }

        $task->task_type_id = $request->task_type_id;
        isset($request->details)? $task->details = $request->details : '';
        $task->task_status_id = $request->task_status_id;
        $task->priority = $request->priority;



        $task->end_date = $end_date;
        $task->end_date = $end_date_hijri;
        $task->task_time = $request->task_time;


        if(isset($request->remind)){
            $task->remind = $request->remind;
            $task->remind_type = $request->remind_type;
            $task->remind_time_id = $request->remind_time_id;
        }

        isset($request->responsible_employee)? $task->responsible_employee = $request->responsible_employee : '';
        $task->save();




        TaskEmployee::where('task_id', $task->id)->delete();

        if(isset($request->task_employees)){
            foreach($request->task_employees as $i => $value){
                $employees[] = [
                    'task_id' => $task->id,
                    'user_id' => $request->task_employees[$i]
                ];
            }
            isset($employees)? TaskEmployee::insert($employees) : '';
        }



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
                    'attachmentable_id' => $task->id,
                    'attachmentable_type' => "App\Models\Task",
                ];
            }
        }
        isset($attachment)? Attachment::insert($attachment): '';


        Session::flash('msg', __('website.data_added'));

        if(isset($request->saveway) && $request->saveway == 1){
            return redirect('/tasks/create');
        }
        else{
            return redirect('/tasks');
        }

    }




    public function getProjects(){
        return Project::where('office_id', Auth::user()->office_id)->get();
    }


    public function getTasks($id){
        return Task::where('project_id', $id)->get();
    }


        public function destroy($id){
        $item = Task::findOrFail($id);
        if(isset($item)){
            $item->delete();
        }
    }


}
