<?php

namespace App\Http\Controllers\Admin;
use App\Models\Country;
use App\Models\Card;
use App\Models\CardTranslation;
use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class PersonalCardsController extends Controller
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
       $items  = Card::latest()->get();       
       return view('admin.personalcards.home', compact('items'));
    }



    public function create()
    {
        return view('admin.personalcards.create');
    }



    public function store(Request $request)
    {
        $locales = Language::all()->pluck('lang');

        $card = new Card();
        
        foreach ($locales as $locale)
        {
            $card->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }
    
        $card->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=Car::all();
    }
    

    public function edit($id)
    {
        $item = Card::findOrFail($id);
        return view('admin.personalcards.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
 
        $item = Card::query()->findOrFail($id);
        
        foreach ($locales as $locale)
        {
            $item->translateOrNew($locale)->name = $request->get('name_' . $locale);
        }        

        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = Card::query()->findOrFail($id);
        if ($item) {
            Card::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
