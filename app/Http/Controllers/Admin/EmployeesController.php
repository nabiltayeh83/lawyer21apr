<?php

namespace App\Http\Controllers\Admin;

use App\Models\EmployeeLocation;
use App\Models\Language;
use App\Models\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Image;
use Laravel\Passport\Bridge\UserRepository;


class EmployeesController extends Controller
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



    public function index(Request $request)
    {
        $items = User::where(['type' => 2, 'parent_id' => 0])->latest()->get();
        return view('admin.employees.home', compact('items'));
    }




    public function create()
    {
        $locales = Language::all();
        return view('admin.employees.create', compact('locales'));
    }



  public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required|unique:users|digits_between:8,12',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $item = new User();
        $item->name = $request->name;
        $item->email = $request->email;
        $item->mobile = $request->mobile;
        // $item->country_id = $request->country_id;
        // $item->city_id = $request->city_id;
        $item->parent_id = 0;
        $item->password = bcrypt($request->password);
        $item->type = 2;
        $item->status = 'active';

        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();
            $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . "." . $extention;
            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/users/$file_name");
            $item->image = $file_name;
        }
        
        $item->save();

        return redirect()->back()->with('status', __('cp.create'));
    }




    public function show($id)
    {
        //
    }



    public function edit($id)
    {
        $item = User::findOrFail($id);
        return view('admin.employees.edit', compact('item'));
    }



    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $roles = [
            'name'     => 'required',
            'mobile' => 'required|digits_between:8,12|unique:users,mobile,'.$user->id,

        ];
        $this->validate($request, $roles);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extention = $image->getClientOriginalExtension();
            $file_name = str_random(15) . "" . rand(1000000, 9999999) . "" . time() . "_" . rand(1000000, 9999999) . "." . $extention;
            Image::make($image)->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save("uploads/images/users/$file_name");
            $user->image = $file_name;
        }
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->save();

        return redirect('/admin/employees')->with('status', __('cp.update'));
    }



    public function destroy($id)
    {
        $item = User::query()->findOrFail($id);
        if ($item) {
            User::query()->where('id', $id)->delete();

            return "success";
        }
        return "fail";
    }



    public function edit_password(Request $request, $id)
    {
        $item = User::findOrFail($id);
        return view('admin.employees.edit_password',['item'=>$item]);
    }


    
    public function update_password (Request $request, $id)
    {
        $users_rules=array(
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password|min:6',
        );
        $users_validation=Validator::make($request->all(), $users_rules);

        if($users_validation->fails())
        {
            return redirect()->back()->withErrors($users_validation)->withInput();
        }
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('status', __('cp.update'));
    }



    public function locations(Request $request,$id)
    {
    
        $locations = EmployeeLocation::query()->where('employee_id',$id);
        if($request->has('date')){
            if ($request->get('date') != null)
            {
                $locations->whereDate('created_at', $request->get('date'));
            }
        }
        $locations = $locations->orderByDesc('created_at')->get();

        $user = User::findOrFail($id);
        return view('admin.employees.location',compact('locations','user'));
    }


}
