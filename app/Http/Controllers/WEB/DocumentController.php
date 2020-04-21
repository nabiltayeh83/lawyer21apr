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
use App\Models\Document;

use Illuminate\Support\Arr;

use PDF;


use App\Models\Activity;
use App\Models\ActivityTranslation;
use App\Models\ActivityProject;



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

class DocumentController extends Controller
{


    public function index(Request $request)
    {
        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        $items = Document::where('office_id', Auth::user()->office_id)->where('parent_id', 0)->orderBy('document_date', 'asc')->get();
        return view('website.documents.home', ['items' => $items]);
    }


    public function documentFilterStatus($status)
    {
        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        if($status == 'all'){
            $items = Document::where('office_id', Auth::user()->office_id)->where('parent_id', 0)->orderBy('document_date', 'asc')->get();
        }

        if($status == 'deleted'){
            $items = Document::where('office_id', Auth::user()->office_id)->where('deleted_at', '<>', null)->withTrashed()->where('parent_id', 0)->orderBy('document_date', 'asc')->get();
        }

        $documentFilter = view('website.extraBlade.filters.documentFilter')->with(['documentFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'documentFilter' => $documentFilter ];
    }




    public function documentFilterText($text)
    {
        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        $items = Document::where('office_id', Auth::user()->office_id)->where('title', 'like', "%$text%")->where('parent_id', 0)->orderBy('document_date', 'asc')->get();

        $documentFilter = view('website.extraBlade.filters.documentFilter')->with(['documentFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'documentFilter' => $documentFilter ];
    }




    public function documentFilterForm(Request $request)
    {
        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        $items = Document::where('office_id', Auth::user()->office_id)->where('parent_id', 0);

        $project_id = $request->project_id;
        $responsible_lawyer = $request->responsible_lawyer;

        if(isset($project_id)){
            $items->where('project_id', $project_id);
        }

        if(isset($responsible_lawyer)){
            $items->where('responsible_lawyer', $responsible_lawyer);
        }

        if(isset($request->from_date) and isset($request->to_date)){
            $from_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->from_date)));
            $to_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->to_date)));
            $items->whereBetween('document_date', [$from_date, $to_date]);
        }

        $items = $items->orderBy('document_date', 'asc')->get();

        $documentFilter = view('website.extraBlade.filters.documentFilter')->with(['documentFilter' => $items])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'documentFilter' => $documentFilter ];

    }


    public function store(Request $request)
    {

        if(!user_role(5)){
            return redirect()->route('HomePage');
        }



        if(isset($request->folder_date)){
            if(date("Y", strtotime($request->folder_date)) == '1970'){
                $document_date = Arr::get(getDates($request->folder_date), 'gregorian_date');
                $document_date_hijri = Arr::get(getDates($request->folder_date), 'hijri_date');
            }
            else{
                $document_date = Arr::get(getDates(date("Y-m-d", strtotime($request->folder_date))), 'gregorian_date');
                $document_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->folder_date))), 'hijri_date');
                $document_date_hijri = convertAr2En($document_date_hijri);
            }
        }

        if(isset($request->document_date)){
            if(date("Y", strtotime($request->document_date)) == '1970'){
                $document_date = Arr::get(getDates($request->document_date), 'gregorian_date');
                $document_date_hijri = Arr::get(getDates($request->document_date), 'hijri_date');
            }
            else{
                $document_date = Arr::get(getDates(date("Y-m-d", strtotime($request->document_date))), 'gregorian_date');
                $document_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->document_date))), 'hijri_date');
                $document_date_hijri = convertAr2En($document_date_hijri);
            }
        }




        if(is_array($request->file('files')))
        {
            foreach($request->file('files') as $file)
            {
                $extension = $file->getClientOriginalExtension();
                $filename  = Auth::user()->user_id."_".time()."_".rand(1,50000). 'doc.' .$extension;
                $destinationPath = 'uploads/websitefiles/attachments';
                $file->move($destinationPath,$filename);

                $documents[] = [
                    'parent_id' => $request->parent_id,
                    'office_id' => Auth::user()->office_id,
                    'title' => $request->title,
                    'responsible_lawyer' => Auth::user()->id,
                    'document_date' => $document_date,
                    'document_date_hijri' => $document_date_hijri,
                    'file' => $filename
                ];
            }
            $item = Document::insert($documents);
            return 0;
        }

        else{
            $item = new Document();
            $item->parent_id = 0;
            $item->office_id = Auth::user()->office_id;
            $item->title = $request->title;
            $item->project_id = $request->project_id;
            $item->responsible_lawyer = Auth::user()->id;
            $item->document_date = $document_date;
            $item->document_date_hijri = $document_date_hijri;
            $item->file = null;
            $item->save();
        }


        if(isset($request->project_id)){
            $activities_projects = new ActivityProject();
            $activities_projects->office_id = Auth::user()->office_id;
            $activities_projects->action_user_id = Auth::user()->id;
            $activities_projects->activity_id = 8;
            $activities_projects->project_id = $request->project_id;
            $activities_projects->save();
            return $item;
        }


    }



    public function show($id)
    {
        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        $item  = Document::findOrFail($id);
        return view('website.documents.documentDetails', [
            'item' => $item,
        ]);
    }


    public function updateFolder(Request $request, $id){

        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        if(isset($request->folder_date)){
            if(date("Y", strtotime($request->folder_date)) == '1970'){
                $document_date = Arr::get(getDates($request->folder_date), 'gregorian_date');
                $document_date_hijri = Arr::get(getDates($request->folder_date), 'hijri_date');
            }
            else{
                $document_date = Arr::get(getDates(date("Y-m-d", strtotime($request->folder_date))), 'gregorian_date');
                $document_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->folder_date))), 'hijri_date');
                $document_date_hijri = convertAr2En($document_date_hijri);
            }
        }

        $item =  Document::findOrFail($id);
        $item->title = $request->title;
        $item->project_id = $request->project_id;
        $item->document_date = $document_date;
        $item->document_date_hijri = $document_date_hijri;
        $item->save();
        return $item;
    }


    public function updateDoucment(Request $request, $id){

        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        if(isset($request->document_date)){
            if(date("Y", strtotime($request->document_date)) == '1970'){
                $document_date = Arr::get(getDates($request->document_date), 'gregorian_date');
                $document_date_hijri = Arr::get(getDates($request->document_date), 'hijri_date');
            }
            else{
                $document_date = Arr::get(getDates(date("Y-m-d", strtotime($request->document_date))), 'gregorian_date');
                $document_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->document_date))), 'hijri_date');
                $document_date_hijri = convertAr2En($document_date_hijri);
            }
        }

        $item =  Document::findOrFail($id);
        $item->title = $request->title;
        $item->parent_id = $request->parent_id;
        $item->document_date = $document_date;
        $item->document_date_hijri = $document_date_hijri;
        $item->save();
        return $item;
    }


    public function edit($id)
    {
        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        $item = Document::findOrFail($id);
        return view('website.documents.edit', [
            'item' => $item,
        ]);
    }


    public function update(Request $request, $id)
    {

        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'name' => "required",
            'task_category' => "required",
            'project_id' => "required_if:task_category,project",
            'task_type_id' => "required",
            'task_status_id' => "required",
            'priority' => "required",
            'end_date' => "required",
            'workgroup_id' => "required",
            'remind_type' => "required_if:remind,yes",
            'remind_time_id' => "required_if:remind,yes",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $task = Document::findOrFail($id);

        $task->name = $request->name;


        if(isset($request->task_category) && $request->task_category == 'project'){
            $task->project_id = $request->project_id;
            $task->task_category = 'project';
        }
        else{
            $task->task_category = 'other';
            $task->project_id = 0;
        }


        $task->task_type_id = $request->task_type_id;
        isset($request->details)? $task->details = $request->details : '';
        $task->task_status_id = $request->task_status_id;
        $task->priority = $request->priority;

        if(isset($request->start_date)){
            $task->start_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->start_date)));
        }

        $task->end_date = date("Y-m-d", strtotime(str_replace('/', '-', $request->end_date)));
        $task->workgroup_id = $request->workgroup_id;

        if(isset($request->remind)){
            $task->remind = $request->remind;
            $task->remind_type = $request->remind_type;
            $task->remind_time_id = $request->remind_time_id;
        }

        isset($request->responsible_employee)? $task->responsible_employee = $request->responsible_employee : '';
        $task->save();

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
            return redirect('/documents/create');
        }
        else{
            return redirect('/documents');
        }

    }


    public function getFolder($id){
        return Document::findOrFail($id);
    }



    public function exportAllDocumentsPDF(){

        if(!user_role(5)){
            return redirect()->route('HomePage');
        }

        $documents = Document::where('office_id', Auth::user()->office_id)->where('parent_id', 0)->get();

        $data =
        [
           'documents' => $documents,
           'logo' => 'assets/img/logo.svg',
           'signature' => 'assets/img/signature2x.png',

        ];

        $pdf = PDF::loadView('website.documents.exportAllDocumentsPDF', $data);
        return $pdf->stream('documents.pdf');
     }



    public function destroy($id)
    {

    }
}
