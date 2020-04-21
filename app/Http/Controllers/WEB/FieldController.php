<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\User;

use Carbon\Carbon;

use App\Models\Field;
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


class FieldController extends Controller
{


    public function index(Request $request)
    {

        $text   = $request->text;
        $items = ProjectHour::where('user_id', Auth::user()->user_id);

         $project_id = $request->project_id;
         $task_id = $request->task_id;
         $responsible_lawyer = $request->responsible_lawyer;
         $hour_status = $request->hour_status;
         $date_from = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_from)));
         $date_to = date("Y-m-d", strtotime(str_replace('/', '-', $request->date_to)));
         
        if(isset($task_id) || isset($project_id) || isset($responsible_lawyer) || isset($hour_status) || (isset($date_from) and isset($date_to))){

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

             if(isset($date_from) and isset($date_to)){
                 $items->whereBetween('start_date', [$date_from, $date_to]);
             }

         }
         else{

             if(isset($request->date)){
                 if($request->date == 'viewThisWeekItems'){
                     $today = Carbon::now()->addDays(7);
                    $items->whereBetween('start_date', [Carbon::now(), $today]);
                 }
                 if($request->date == 'viewThisMonthItems'){
                    $items->whereMonth('start_date', Carbon::now()->month);
                }

             }

             if(isset($text)){
                 $items->where('hour_details', 'like', "%$text%");
                 $items->where('hour_office_details', 'like', "%$text%");
             }
        }

        $items = $items->orderBy('start_date', 'asc')->get();

        return view('website.hours.home', [
            'items' => $items,
            'text' => $text,
        ]);
    }


    public function create()
    {
        return view('website.h

        ours.create');
    }





    public function store(Request $request)
    {

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'type' => "required",
            'name' => "required",
            // 'required' => "required",
            // 'apply_to' => "required",
        ];

        $customMessages = [
            'required' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        $items = new Field();
        $items->office_id = Auth::user()->office_id;
        $items->type = $request->type;
        $items->name = $request->name;
        $items->required = isset($request->required)? 'no' : 'yes';
        $items->apply_to = isset($request->apply_to)? 'this_project' : 'all_projects';
        $items->save();
        return $items;
    }



    public function show($id)
    {
        $item  = ProjectHour::findOrFail($id);
        return view('website.hours.hourDetails', [
            'item' => $item,
        ]);
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




    public function changeTaskStatus($task_id, $newStatus)
    {
        $item  = Task::findOrFail($task_id);
        $item->task_status_id = $newStatus;
        $item->save();
    }




    public function edit($id)
    {
        $item = ProjectHour::findOrFail($id);
        return view('website.hours.edit', [
            'item' => $item,
            'project_tasks' => Task::where('project_id', $item->project_id)->get(),
        ]
    );
    }



    public function update(Request $request, $id)
    {

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'project_id' => "required",
            'task_id' => "required",
            'responsible_lawyer' => "required",
            'hours_count' => "required",
            'price' => "required",
            'start_date' => "required",
            'hour_status' => "required",
            'hour_details' => "required",
            'hour_office_details' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $project_hour = ProjectHour::findOrFail($id);

        $project_hour->project_id = $request->project_id;
        $project_hour->task_id = $request->task_id;
        $project_hour->responsible_lawyer = $request->responsible_lawyer;
        $project_hour->hours_count = $request->hours_count;
        $project_hour->price = $request->price;
        $project_hour->start_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
        $project_hour->hour_status = $request->hour_status;
        $project_hour->hour_details = $request->hour_details;
        $project_hour->hour_office_details = $request->hour_office_details;

        $project_hour->save();
        return redirect('/hours');

    }


    public function destroy($id)
    {

    }

}
