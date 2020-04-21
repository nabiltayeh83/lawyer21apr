<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClientDescription;
use App\Models\ClientDescriptionTranslation;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ClientDescriptionController extends Controller
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
       $items  = ClientDescription::latest()->get();       
       return view('admin.clients_descriptions.home', compact('items'));
    }



    public function create()
    {
        return view('admin.clients_descriptions.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $item = new ClientDescription();
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $item->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=ClientDescription::all();
    }
    

    public function edit($id)
    {
        $item = ClientDescription::findOrFail($id);
        return view('admin.clients_descriptions.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = ClientDescription::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = ClientDescription::query()->findOrFail($id);
        if ($item) {
            ClientDescription::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
