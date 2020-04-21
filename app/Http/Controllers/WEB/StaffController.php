<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use App\User;

use Carbon\Carbon;

use App\Models\City;
use App\Models\CityTranslation;

use App\Models\Attachtype;
use App\Models\AttachtypeTranslation;
use App\Models\Language;
use App\Models\LanguageTranslation;
use App\Models\Attachment;
use App\Models\Client;
use App\Models\Task;
use App\Models\Role;
use App\Models\RoleTranslation;
use App\Models\Representative;
use App\Models\Card;
use App\Models\Note;
use App\Models\Project;

use App\Models\TaskEmployee;


use Dotenv\Exception\ValidationException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use App\Models\Activity;
use App\Models\ActivityTranslation;
use App\Models\ActivityProject;

use Auth;
use Session;

class StaffController extends Controller
{



    public function index(Request $request)
    {

        $users = User::where('parent_id', Auth::user()->office_id)->orderBy('id', 'desc')->get();
     
        return view('website.staff.home', [
            'users' => $users,
        ]);

    }



    public function create()
    {
        return view('website.tasks.create');
    }



    public function store(Request $request)
    {

        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        $rules = [
            'name' => "required",
            'email' => "required|unique:users",
            'mobile' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);


        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $item = new User();

        $item->parent_id = Auth::user()->office_id;
        $item->name = $request->name;
        $item->email = $request->email;
        $item->mobile = $request->mobile;
        $item->hour_price = $request->hour_price;
        $item->address = $request->address;
        $item->role_group_id = $request->role_group_id;
        $item->save();

        Session::flash('msg', __('website.data_added'));

        if(isset($request->saveway) && $request->saveway == 1){
            return redirect()->back();
        }
        else{
            return redirect('/staff');
        }

    }


    public function edit($id)
    {
        $item = User::findOrFail($id);
        return view('website.staff.edit', ['item' => $item]);
    }


    public function update(Request $request, $id)
    {
        $locales = Language::all()->pluck('lang');
        $validator = Validator::make($request->all(), []);

        // $rules = [
        //     'name' => "required",
        //     'email' => "required|unique:users",
        //     'mobile' => "required",
        //     ];

        // $customMessages = [
        //     'required' => __('website.required_field'),
        //     'required_if' => __('website.required_field'),
        //     ];

        // $this->validate($request, $rules, $customMessages);


        // if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $item = User::findOrFail($id);
        
        $item->name = $request->name;
        $item->email = $request->email;
        $item->mobile = $request->mobile;
        $item->hour_price = $request->hour_price;
        $item->address = $request->address;
        $item->role_group_id = $request->role_group_id;
        $item->save();

        Session::flash('msg', __('website.data_added'));

        if(isset($request->saveway) && $request->saveway == 1){
            return redirect('/staff/create');
        }
        else{
            return redirect('/staff');
        }

    }
    

    public function destroy($id)
    {

    }
}
