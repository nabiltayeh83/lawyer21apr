<?php

namespace App\Http\Controllers\Admin;

use App\Models\Zone;

use App\Models\JobTitle;
use App\Models\Language;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ZoneController extends Controller
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
       $items  = Zone::latest()->get();       
       return view('admin.zones.home', compact('items'));
    }



    public function create()
    {
        return view('admin.zones.create');
    }



    public function store(Request $request)
    {

        $item = new Zone();
        $item->name = $request->name;
        $item->save();
        return redirect()->back()->with('status', __('cp.create'));

    }


    public function show($id)
    {
        $item=Zone::all();
    }
    

    public function edit($id)
    {
        $item = Zone::findOrFail($id);
        return view('admin.zones.edit', ['item' => $item]);
    }



    public function update(Request $request, $id)
    {
        $item = Zone::query()->findOrFail($id);
        $item->name = $request->name;
        $item->save();

        return redirect()->back()->with('status', __('cp.update'));

    }


    

    public function destroy($id)
    {
        $item = Zone::query()->findOrFail($id);
        if ($item) {
            Zone::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }

}
