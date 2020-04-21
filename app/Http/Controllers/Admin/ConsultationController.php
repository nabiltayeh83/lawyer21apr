<?php

namespace App\Http\Controllers\Admin;

use App\Models\Consultation;
use App\Models\ConsultationTranslation;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ConsultationController extends Controller
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
       $items  = Consultation::latest()->get();       
       return view('admin.consultations.home', compact('items'));
    }



    public function create()
    {
        return view('admin.consultations.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $item = new Consultation();
        
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
        $item = Consultation::findOrFail($id);
        return view('admin.consultations.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = Consultation::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = Consultation::query()->findOrFail($id);
        if ($item) {
            Consultation::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
