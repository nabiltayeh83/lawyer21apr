<?php

namespace App\Http\Controllers\Admin;

use App\Models\TaskStatus;
use App\Models\TaskStatusTranslation;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class TaskStatusController extends Controller
{
    
    public function __construct()
    {
        $this->locales = Language::all();
        $this->settings = Setting::query()->first();
        view()->share([
            'locales' => $this->locales,
            'settings' => $this->settings,

        ]);
    }



    public function index()
    {
       $items  = TaskStatus::latest()->get();       
       return view('admin.tasks_status.home', compact('items'));
    }



    public function create()
    {
        return view('admin.tasks_status.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $item = new TaskStatus();
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $item->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=TaskStatus::all();
    }
    

    public function edit($id)
    {
        $item = TaskStatus::findOrFail($id);
        return view('admin.tasks_status.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = TaskStatus::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = TaskStatus::query()->findOrFail($id);
        if ($item) {
            TaskStatus::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
