<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;


class SettingController extends Controller
{
    private $locales = '';

    public function __construct()
    {
        $this->locales = Language::all();
        view()->share([
            'locales' => $this->locales,
        ]);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function image_extensions(){

        return array('jpg','png','jpeg','gif','bmp','pdf','txt','docx','doc','ppt','xls','zip','rar', 'svg');

    }


    public function index()
    {
        $item = Setting::query()->first();
        return view('admin.settings.edit', compact('item'));
    }

    public function update(Request $request)
    {
       //dd($request->all());
        $locales = Language::all()->pluck('lang');
        $roles = [
//            'logo' => 'required',
            'admin_email' => 'required|email',
            'info_email' => 'required|email',
            'app_store_url' => 'required|url',
            'play_store_url' => 'required|url',
            'mobile' => 'required|numeric',
            'phone' => 'numeric',
            'facebook' => 'required|url',
            'twitter' => 'required|url',
           'google_plus' => 'url',
            'linked_in' => 'required|url',
           'instagram' => 'url',
           'time_from' => 'required',
           'time_to' => 'required',
        ];
        foreach ($locales as $locale) {
            $roles['title_' . $locale] = 'required';
            $roles['address_' . $locale] = 'required';
            $roles['key_words_' . $locale] = 'required';
            $roles['description_' . $locale] = 'required';
        }
        $this->validate($request, $roles);
        $setting = Setting::query()->findOrFail(1);
       // $setting->url = trim($request->get('url'));
        $setting->admin_email = trim($request->get('admin_email'));
        $setting->info_email = trim($request->get('info_email'));
        $setting->app_store_url = trim($request->get('app_store_url'));
        $setting->play_store_url = trim($request->get('play_store_url'));
        $setting->mobile = trim($request->get('mobile'));
        $setting->phone = trim($request->get('phone'));
        $setting->facebook = trim($request->get('facebook'));
        $setting->twitter = trim($request->get('twitter'));
        $setting->google_plus = trim($request->get('google_plus'));
        $setting->linked_in = trim($request->get('linked_in'));
        $setting->instagram = trim($request->get('instagram'));
        $setting->latitude = trim($request->get('latitude'));
        $setting->longitude = trim($request->get('longitude'));
        $setting->time_from = $request->get('time_from');
        $setting->time_to = $request->get('time_to');


        if ($request->hasFile('logo')) {
           $image = $request->file('logo');
           $imageName = date("dHis-").preg_replace("/[^a-zA-Z0-9.]/","",$image->getClientOriginalName());
           $uploadPath = public_path('uploads/settings/');
           $image->move($uploadPath,$imageName);
           $setting->logo = $imageName;
        }


        if ($request->hasFile('logo_white')) {
            $image = $request->file('logo_white');
            $imageName = date("dHis-").preg_replace("/[^a-zA-Z0-9.]/","",$image->getClientOriginalName());
            $uploadPath = public_path('uploads/settings/');
            $image->move($uploadPath,$imageName);
            $setting->logo_white = $imageName;
         }


        foreach ($locales as $locale) {
            $setting->translate($locale)->title = trim(ucwords($request->get('title_' . $locale)));
            $setting->translate($locale)->address = trim(ucwords($request->get('address_' . $locale)));
            $setting->translate($locale)->key_words = trim(ucwords($request->get('key_words_' . $locale)));
            $setting->translate($locale)->description = ucwords($request->get('description_' . $locale));
        }
        $setting->save();
        return redirect()->back()->with('status', 'setting updated successfully');
    }
}
