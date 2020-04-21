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
use App\Models\RoleGroupDepartment;
use App\Models\RoleGroup;



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

class RoleGroupController extends Controller
{

    public function index(Request $request)
    {
        $items = RoleGroup::where('office_id', Auth::user()->office_id)->orderBy('id', 'desc')->get();
        return view('website.roles_settings.home', ['items' => $items]);
    }


    public function create()
    {
        return view('website.roles_settings.create');
    }



    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), []);

        $rules = [
            'name' => "required",
            'departments' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $item = new RoleGroup();

        $item->office_id = Auth::user()->office_id;
        $item->name = $request->name;
        $item->save();

        foreach($request->departments as $i => $value){
            $departments[] = [
                'role_group_id' => $item->id,
                'department_id' => $request->departments[$i]
            ];
        }
        isset($departments)? RoleGroupDepartment::insert($departments) : '';
        
        Session::flash('msg', __('website.data_added'));
        return redirect('/roles_settings');
    }




    public function edit($id)
    {
        $item = RoleGroup::findOrFail($id);
        $roles_groups_departments = RoleGroupDepartment::where('role_group_id', $id)->pluck('department_id')->toArray();
        return view('website.roles_settings.edit', ['item' => $item, 'roles_groups_departments' => $roles_groups_departments]);
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), []);

        $rules = [
            'name' => "required",
            'departments' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            'required_if' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);
        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $item = RoleGroup::findOrFail($id);

        $item->name = $request->name;
        $item->save();

        RoleGroupDepartment::where('role_group_id', $item->id)->delete();
        
        foreach($request->departments as $i => $value){
            $departments[] = [
                'role_group_id' => $item->id,
                'department_id' => $request->departments[$i]
            ];
        }
        isset($departments)? RoleGroupDepartment::insert($departments) : '';

        Session::flash('msg', __('website.data_added'));
        return redirect('/roles_settings');
    }


    public function destroy($id)
    {

    }
}
