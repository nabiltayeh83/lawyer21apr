<?php

namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Note;
use Illuminate\Support\Arr;
use App\Models\Activity;
use App\Models\ActivityTranslation;
use App\Models\ActivityProject;

use Auth;


class NoteController extends Controller
{


    public function getNote($id){
        return Note::findOrFail($id);
    }


    public function updateNote(Request $request, $id){
    
        if(isset($request->note_date)){
            if(date("Y", strtotime($request->note_date)) == '1970'){
                $note_date = Arr::get(getDates($request->note_date), 'gregorian_date');
                $note_date_hijri = Arr::get(getDates($request->note_date), 'hijri_date');
            }
            else{
                $note_date = Arr::get(getDates(date("Y-m-d", strtotime($request->note_date))), 'gregorian_date');
                $note_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->note_date))), 'hijri_date');
                $note_date_hijri = convertAr2En($note_date_hijri);
            }
        }

        $note =  Note::findOrFail($id);
        $note->note = $request->note;
        $note->note_date = $note_date;
        $note->note_date_hijri = $note_date_hijri;
        $note->save();
        return $note;
    }



    public function create_note(Request $request)
    {

        if(isset($request->segment) && $request->segment == 'clients'){
            $noteable_type = 'App\Models\Client';
        }

        if(isset($request->segment) && $request->segment == 'projects'){
            $noteable_type = 'App\Models\Project';
            $activities_projects = new ActivityProject();
            $activities_projects->office_id = Auth::user()->office_id;
            $activities_projects->action_user_id = Auth::user()->id;
            $activities_projects->activity_id = 5;
            $activities_projects->project_id = $request->segment_id;
            $activities_projects->save();
        }

        if(isset($request->note_date)){
            if(date("Y", strtotime($request->note_date)) == '1970'){
                $note_date = Arr::get(getDates($request->note_date), 'gregorian_date');
                $note_date_hijri = Arr::get(getDates($request->note_date), 'hijri_date');
            }
            else{
                $note_date = Arr::get(getDates(date("Y-m-d", strtotime($request->note_date))), 'gregorian_date');
                $note_date_hijri = Arr::get(getDates(date("Y-m-d", strtotime($request->note_date))), 'hijri_date');
                $note_date_hijri = convertAr2En($note_date_hijri);
            }
        }

        $note = new Note();
        $note->note = $request->note;
        $note->note_date = $note_date;
        $note->note_date_hijri = $note_date_hijri;
        $note->noteable_id = $request->segment_id;
        $note->noteable_type = $noteable_type;
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


}
