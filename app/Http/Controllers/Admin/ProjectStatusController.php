<?php

namespace App\Http\Controllers\Admin;

use App\Models\Projectstatus;
use App\Models\ProjectstatusTranslation;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ProjectStatusController extends Controller
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
       $items  = Projectstatus::latest()->get();       
       return view('admin.projectstatus.home', compact('items'));
    }



    public function create()
    {
        return view('admin.projectstatus.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $projectstatus = new Projectstatus();
        
        foreach ($locales as $locale)
        {
            $projectstatus->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $projectstatus->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=Car::all();
    }
    

    public function edit($id)
    {
        $item = Projectstatus::findOrFail($id);
        return view('admin.projectstatus.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = Projectstatus::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = Projectstatus::query()->findOrFail($id);
        if ($item) {
            Projectstatus::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
