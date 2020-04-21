<?php

namespace App\Http\Controllers\Admin;

use App\Models\AspectExpense;
use App\Models\AspectExpenseTranslation;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class AspectExpenseController extends Controller
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
       $items  = AspectExpense::latest()->get();       
       return view('admin.aspect_expenses.home', compact('items'));
    }



    public function create()
    {
        return view('admin.aspect_expenses.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $item = new AspectExpense();
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $item->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=AspectExpense::all();
    }
    

    public function edit($id)
    {
        $item = AspectExpense::findOrFail($id);
        return view('admin.aspect_expenses.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = AspectExpense::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = AspectExpense::query()->findOrFail($id);
        if ($item) {
            AspectExpense::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
