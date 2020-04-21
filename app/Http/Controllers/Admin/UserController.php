<?php
namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Setting;
use App\Models\City;

use Dotenv\Exception\ValidationException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewPostNotification;
use Image;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->settings = Setting::query()->first();
        view()->share([
            'settings' => $this->settings,
        ]);
    }



    public function index(Request $request)
    {
        $items = User::query();
       
       
        if($request->has('name')){
            $items->where('name', 'like', '%' . $request->get('name') . '%');
        }
        
        if($request->has('email')){
            $items->where('email', 'like', '%' . $request->get('email') . '%');
        }

        if($request->has('mobile')){
            $items->where('mobile', 'like', '%' . $request->get('mobile') . '%');
        }
        
        if($request->has('address')){
            $items->where('address', 'like', '%' . $request->get('address') . '%');
        }
        
        if(isset($request->country_id)){
            $items->where('country_id', $request->country_id);
        }
        
        if(isset($request->status)){
            $items->where('status', $request->status);
        }

        $items = $items->where(['type' => '1', 'parent_id' => 0]);
        $items = $items->latest()->get();

        return view('admin.users.home', ['items' => $items]);

    }




    public function create()
    {
        return view('admin.users.create');
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
        $item->country_id = $request->country_id;
        $item->city_id = $request->city_id;
        $item->address = $request->address;
        $item->zone_id = $request->zone_id;
        $item->password = bcrypt($request->password);
        $item->type = 1;
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
        $item = User::findOrFail($id);
        return view('admin.users.show', ['item' => $item]);
    }


    public function edit($id)
    {
        $item = User::findOrFail($id);
        $cities = City::where('country_id', $item->country_id)->get();
        return view('admin.users.edit', ['item' => $item, 'cities' => $cities]);
    }



    public function update(Request $request, $id)
    {
        $user= User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required|digits_between:8,12|unique:users,mobile,'.$user->id,
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

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
        $user->country_id = $request->country_id;
        $user->city_id = $request->city_id;
        $user->address = $request->address;
        $user->zone_id = $request->zone_id;
        $user->save();

        return redirect('/admin/users')->with('status', __('cp.update'));
    }



    public function edit_password(Request $request, $id)
    {
        $item = User::findOrFail($id);
        return view('admin.users.edit_password', ['item' => $item]);
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


    public function changeStatus(Request $request)
    {
        dd($request->IDsArray) ;
        if ($request->event == 'delete') {
            User::query()->whereIn('id', $request->IDsArray)->delete();
        } else {
            User::query()->whereIn('id', $request->IDsArray)->update(['status' => $request->event]);
        }
        return $request->event;
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


}
