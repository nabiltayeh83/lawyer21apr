<?php

namespace App\Http\Controllers\Admin;

use App\Models\TaskType;
use App\Models\TaskTypeTranslation;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class TaskTypeController extends Controller
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
       $items  = TaskType::latest()->get();       
       return view('admin.tasks_types.home', compact('items'));
    }



    public function create()
    {
        return view('admin.tasks_types.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $item = new TaskType();
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $item->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=TaskType::all();
    }
    

    public function edit($id)
    {
        $item = TaskType::findOrFail($id);
        return view('admin.tasks_types.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = TaskType::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = TaskType::query()->findOrFail($id);
        if ($item) {
            TaskType::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
