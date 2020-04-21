<?php

namespace App\Http\Controllers\WEB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Models\Event;
use App\Models\Task;
use Auth;

class EventController extends Controller
{


    public function index(){
        $events = Event::where('office_id', Auth::user()->office_id)->whereDate('start_date', '>=', Carbon::now())->orderBy('start_date', 'desc')->get();
        $tasks  = Task::where('office_id', Auth::user()->office_id)->whereDate('end_date', '>=', Carbon::now())->orderBy('end_date', 'desc')->get();
        return view('website.home.calendar', ['events' => $events, 'tasks' => $tasks]);
    }


    public function store(Request $request){

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


        $item = new Event();
        $item->office_id = Auth::user()->office_id;
        $item->title = $request->title;
        $item->type = $request->type;

        $item->start_date = $start_date;
        $item->start_date_hijri = $start_date_hijri;
        $item->start_time = $request->start_time;


        $item->end_date = $end_date;
        $item->end_date_hijri = $end_date_hijri;
        $item->end_time = $request->end_time;

        $item->details = $request->details;
        $item->save();
        return $item;
    }


    public function delete($id){
        $item = Event::findOrFail($id);
        if(isset($item)){
            $item->delete();
        }
    }

}
