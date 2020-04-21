<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\User;
use Illuminate\Support\Arr;

use Redirect;
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

use App\Models\ProjectHour;

use App\Models\Report;
use App\Models\ReportExpense;
use App\Models\ReportHour;
use App\Models\ReportOutput;
use App\Models\ReportOutputTranslation;
use App\Models\ReportReportOutput;
use App\Models\ReportTask;



use Auth;
use Session;

class ReportController extends Controller
{

    public function index(Request $request)
    {
          if(!user_role(8)){
            return redirect()->route('HomePage');
        }

        $items = Report::where('office_id', Auth::user()->office_id)->orderBy('id', 'desc')->get();
        return view('website.reports.home', ['items' => $items]);
    }



    public function reportFilterStatus($status)
    {
            if(!user_role(8)){
            return redirect()->route('HomePage');
        }

        if($status == 'all'){
            $items = Report::where('office_id', Auth::user()->office_id)->orderBy('id', 'desc')->get();
        }

        else{
            $items = Report::where('office_id', Auth::user()->office_id)->where('status', $status)->orderBy('id', 'desc')->get();
        }

        $reportFilter = view('website.extraBlade.filters.reportFilter')->with(['reportFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'reportFilter' => $reportFilter ];
    }



    public function reportFilterText($text)
    {
            if(!user_role(8)){
            return redirect()->route('HomePage');
        }

        $items = Report::where('office_id', Auth::user()->office_id)->where('report_content', 'like', "%$text%")->orderBy('id', 'desc')->get();

        $reportFilter = view('website.extraBlade.filters.reportFilter')->with(['reportFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'reportFilter' => $reportFilter ];
    }





    public function reportFilterForm(Request $request)
    {

    if(!user_role(8)){
            return redirect()->route('HomePage');
        }

        $items = Report::where('office_id', Auth::user()->office_id);


        if(isset($request->client_id)){
            $items->where('client_id', $request->client_id);
        }

        if(isset($request->responsible_lawyer)){
            $items->where('responsible_lawyer', $request->responsible_lawyer);
        }

        if(isset($request->from_date) and isset($request->to_date)){
            $from_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->from_date)));
            $to_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->to_date)));
            $items->whereBetween('created_at', [$from_date, $to_date]);
        }

        $items = $items->latest()->get();

        $reportFilter = view('website.extraBlade.filters.reportFilter')->with(['reportFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'reportFilter' => $reportFilter ];

    }


    public function create()
    {
            if(!user_role(8)){
            return redirect()->route('HomePage');
        }

        return view('website.reports.create');
    }






    public function store(Request $request)
    {

    if(!user_role(8)){
            return redirect()->route('HomePage');
        }

        $validator = Validator::make($request->all(), []);

        $rules = [
            'project_id' => "required",
            'task_id' => "required",
            'report_content' => "required",
            'report_office_content' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        if(isset($request->next_date)){
            if(date("Y", strtotime($request->next_date)) == '1970'){
                $next_date = Arr::get(getDates($request->next_date), 'gregorian_date');
                $next_date_hijri = Arr::get(getDates($request->next_date), 'hijri_date');
            }
            else{
                $next_date = Arr::get(getDates(date("Y-m-d", strtotime($request->next_date))), 'gregorian_date');
                $next_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->next_date))), 'hijri_date');
                $next_date_hijri = convertAr2En($next_date_hijri);
            }
        }

        $item = new Report();
        $item->office_id = Auth::user()->office_id;
        $item->responsible_lawyer = Auth::user()->id;
        $item->project_id = $request->project_id;

        $project = Project::where('id', $request->project_id)->first();
        $item->client_id = $project->client_id;

        $item->task_id = $request->task_id;
        $item->report_content = $request->report_content;
        $item->report_office_content = $request->report_office_content;
        $item->next_date = $next_date;
        $item->next_date_hijri = $next_date_hijri;
        $item->next_time = $request->next_time;
        $item->appendix = $request->appendix;
        $item->save();


        if(isset($request->reports_outputs)){
            foreach($request->reports_outputs as $i => $value){
                $reports_outputs[] = [
                    'report_id' => $item->id,
                    'report_output_id' => $request->reports_outputs[$i]
                ];
            }
            isset($reports_outputs)? ReportReportOutput::insert($reports_outputs) : '';
        }


        if(isset($request->projectHours)){
            foreach ($request->projectHours as $one){
                $projectHours[] = [
                    'report_id' => $item->id,
                    'hour_id' => $one,
                ];
            }
            isset($projectHours)? ReportHour::insert($projectHours): '';
        }



        if(isset($request->projectExpenses)){
            foreach ($request->projectExpenses as $one){
                $projectExpenses[] = [
                    'report_id' => $item->id,
                    'expense_id' => $one,
                ];
            }
            isset($projectExpenses)? ReportExpense::insert($projectExpenses): '';
        }


        if(isset($request->projectTasks)){
            foreach ($request->projectTasks as $one){
                $projectTasks[] = [
                    'report_id' => $item->id,
                    'task_id' => $one,
                ];
            }
            isset($projectTasks)? ReportTask::insert($projectTasks): '';
        }


        if(isset($request->attachment_name)){
            foreach ($request->attachment_name as $i => $value){
                if(isset($request->attachment_name[$i]) && isset($request->attachfile[$i])){
                    $file = $request->attachfile[$i];
                    $extension = $file->getClientOriginalExtension();
                    $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'rep.' .$extension;
                    $destinationPath = 'uploads/websitefiles/attachments';
                    $file->move($destinationPath,$filename);
                    $attachment[] = [
                        'attachment_name' => $request->attachment_name[$i],
                        'file' => $filename,
                        'attachmentable_id' => $item->id,
                        'attachmentable_type' => "App\Models\Report",
                    ];
                }
            }
            isset($attachment)? Attachment::insert($attachment): '';
        }



        if(isset($request->saveway) && $request->saveway == 1){
            return redirect()->back();
        }
        else{
            return redirect('/reports');
        }

    }


    public function show($id)
    {
            if(!user_role(8)){
            return redirect()->route('HomePage');
        }

        $item  = Report::with('reportHours')->findOrFail($id);
        $report_hours = ReportHour::where('report_id', $id)->get();
        $report_hours_count = 0;


        if(isset($report_hours)){
            foreach($report_hours as $one){
                $hour = ProjectHour::where('id', $one->hour_id)->first();
                if($hour){
                   $report_hours_count += $hour->hours_count;
                }
            }
        }

        return view('website.reports.reportDetails', [
            'item' => $item,
            'report_hours_count' => $report_hours_count
        ]);
    }



    public function edit($id)
    {
            if(!user_role(8)){
            return redirect()->route('HomePage');
        }

        $item = Report::findOrFail($id);
        $project_id = $item->project_id;
        $projects = Project::where('client_id', $item->id)->get();

        $project_hours = ProjectHour::where('project_id', $project_id)->get();
        $report_hours = ReportHour::where('report_id', $id)->pluck('hour_id')->toArray();

        $project_expenses = Expense::where('project_id', $project_id)->get();
        $report_expenses = ReportExpense::where('report_id', $id)->pluck('expense_id')->toArray();


        $project_tasks = Task::where('project_id', $project_id)->get();
        $report_tasks = ReportTask::where('report_id', $id)->pluck('task_id')->toArray();

        $reports_reports_outputs = ReportReportOutput::where('report_id', $id)->pluck('report_output_id')->toArray();


        return view('website.reports.edit', [
            'item' => $item,
            'projects' => $projects,

            'project_hours' => $project_hours,
            'report_hours' => $report_hours,
            'project_expenses' => $project_expenses,
            'report_expenses' => $report_expenses,

            'project_tasks' => $project_tasks,
            'report_tasks' => $report_tasks,

            'reports_reports_outputs' => $reports_reports_outputs,

        ]);
    }



    public function update(Request $request, $id)
    {
            if(!user_role(8)){
            return redirect()->route('HomePage');
        }


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

        $item = Report::findOrFail($id);


        if(isset($request->project_id)){
            $expense->project_id = $request->project_id;
        }else{
            $expense->project_id = null;
        }

        $project = Project::where('id', $request->project_id)->first();
        $item->client_id = $project->client_id;

        $item->aspect_expense_id = $request->aspect_expense_id;
        $item->reference_number = $request->reference_number;
        $item->expense_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->expense_date)));
        $item->total_amount = $request->total_amount;
        $item->expense_details = $request->expense_details;
        $item->expense_office_details = $request->expense_office_details;
        $item->responsible_lawyer = $request->responsible_lawyer;
        $item->save();


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
                    'attachmentable_id' => $item->id,
                    'attachmentable_type' => "App\Models\Report",
                ];
            }
        }
        isset($attachment)? Attachment::insert($attachment): '';

        Session::flash('msg', __('website.data_added'));

        if(isset($request->saveway) && $request->saveway == 1){
            return redirect('/reports/create');
        } else{
            return redirect('/reports');
        }

    }



        public function reportExportPDF($id){

            if(!user_role(8)){
                return redirect()->route('HomePage');
            }

            $report = Report::findOrFail($id);

            $data =
            [
               'report' => $report,
               'logo' => 'assets/img/logo.svg',
               'signature' => 'assets/img/signature2x.png',

            ];

            $pdf = PDF::loadView('website.reports.reportExportPDF', $data);
            return $pdf->stream('report' . $report->id . '.pdf');

         }






    public function destroy($id)
    {
    }

}
