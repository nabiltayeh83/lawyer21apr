<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lawsuit;
use App\Models\LawsuitTranslation;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class LawsuitsController extends Controller
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
       $items  = Lawsuit::latest()->get();       
       return view('admin.lawsuits.home', compact('items'));
    }



    public function create()
    {
        return view('admin.lawsuits.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $item = new Lawsuit();
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $item->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=Lawsuit::all();
    }
    

    public function edit($id)
    {
        $item = Lawsuit::findOrFail($id);
        return view('admin.lawsuits.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = Lawsuit::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = Lawsuit::query()->findOrFail($id);
        if ($item) {
            Lawsuit::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
