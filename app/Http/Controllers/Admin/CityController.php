<?php

namespace App\Http\Controllers\Admin;
use App\Models\Country;
use App\Models\CountryTranslation;

use App\Models\Category;
use App\Models\CategoryTranslation;

use App\Models\City;
use App\Models\CityTranslation;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class CityController extends Controller
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
       $items  = City::latest()->get();       
       return view('admin.city.home', compact('items'));
    }



    public function create()
    {
        $countries  = Country::all();
        return view('admin.city.create', compact('countries'));
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $city = new City();
        $city->country_id = $request->country_id;
        
        foreach ($locales as $locale)
        {
            $city->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $city->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=Car::all();
    }
    

    public function edit($id)
    {
        $item = city::findOrFail($id);
        $countries  = Country::all();
        return view('admin.city.edit', compact('item', 'countries'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = City::query()->findOrFail($id);
        $item->country_id  = $request->country_id;

        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = City::query()->findOrFail($id);
        if ($item) {
            City::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
