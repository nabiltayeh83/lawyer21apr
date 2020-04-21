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
use App\Models\Expense;
use App\Models\AspectExpense;
use App\Models\AspectExpenseTranslation;

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

use App\Models\FlatFee;


use Auth;
use Session;

class FlatFeeController extends Controller
{



    public function InvoiceFlatsFees(Request $request)
    {

        $validator = Validator::make($request->all(), []);

        $rules = [
            'project_id' => "required",
            'price' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        
        $item = new FlatFee();

        $item->office_id = Auth::user()->office_id;
        $item->project_id = $request->project_id;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->date = date("Y-m-d", strtotime(str_replace('/', '-', $request->date)));
        $item->save();
        
        $projectFlatsFees = view('website.extraBlade.invoices.newProjectFlatsFees')->with(['projectFlatsFees' => $item ])->render();
        return ['status' => true, 'message' =>  __('site.DoneSuccessfully'), 'projectFlatsFees' => $projectFlatsFees ];

    }







    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), []);

        $rules = [
            'project_id' => "required",
            'price' => "required",
            ];

        $customMessages = [
            'required' => __('website.required_field'),
            ];

        $this->validate($request, $rules, $customMessages);

        if ($validator->fails()) { return back()->withErrors($validator)->withInput(); }

        $item = new FlatFee();
        $item->office_id = Auth::user()->office_id;
        $item->project_id = $request->project_id;
        $item->price = $request->price;
        $item->description = $request->description;
        $item->date = date("Y-m-d", strtotime(str_replace('/', '-', $request->date)));
        $item->save();
        return $item;
    }










   


}
