<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contender;
use App\Models\ContenderTranslation;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ContenderController extends Controller
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
       $items  = Contender::latest()->get();       
       return view('admin.contenders.home', compact('items'));
    }



    public function create()
    {
        return view('admin.contenders.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $item = new Contender();
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $item->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=Contender::all();
    }
    

    public function edit($id)
    {
        $item = Contender::findOrFail($id);
        return view('admin.contenders.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = Contender::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = Contender::query()->findOrFail($id);
        if ($item) {
            Contender::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
