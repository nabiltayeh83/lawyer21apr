<?php

namespace App\Http\Controllers\Admin;

use App\Models\OfficeEmployee;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class OfficeEmployeeController extends Controller
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
       $items  = OfficeEmployee::latest()->get();       
       return view('admin.office_employees.home', compact('items'));
    }



    public function create()
    {
        return view('admin.office_employees.create');
    }



    public function store(Request $request)
    {

        $city = new OfficeEmployee();
        $city->country_id = $request->country_id;
        
     
    
        $city->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=OfficeEmployee::all();
    }
    

    public function edit($id)
    {
        // $item = OfficeEmployee::findOrFail($id);
        // return view('admin.office_employees.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        // $locales = Language::all()->pluck('lang');
 
        // $item = City::query()->findOrFail($id);
        // $item->country_id  = $request->country_id;

        // foreach ($locales as $locale)
        // {
        //     $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        // }        

        // $item->save();

        // return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = OfficeEmployee::query()->findOrFail($id);
        if ($item) {
            OfficeEmployee::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
