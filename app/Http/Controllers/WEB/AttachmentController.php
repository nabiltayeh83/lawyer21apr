<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;

use App\User;
use App\Models\Note;
use App\Models\Attachment;
use App\Models\ActivityProject;

use Dotenv\Exception\ValidationException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use Auth;
use Carbon\Carbon;

class AttachmentController extends Controller
{

    public function createAttach(Request $request)
    {
            $file = $request->attachfile;
            $extension = $file->getClientOriginalExtension();
            $filename  = Auth::user()->user_id."_".time()."_".rand(1,999999). '.' .$extension;
            $destinationPath = 'uploads/websitefiles/attachments';
            $file->move($destinationPath,$filename);


            if(isset($request->segment) && $request->segment == 'clients'){
                $noteable_type = 'App\Models\Client';
            }
            
            if(isset($request->segment) && $request->segment == 'projects'){
                $noteable_type = 'App\Models\Project';
                $activities_projects = new ActivityProject();
                $activities_projects->office_id = Auth::user()->office_id;
                $activities_projects->action_user_id = Auth::user()->id;
                $activities_projects->activity_id = 7;
                $activities_projects->project_id = $request->segment_id;
                $activities_projects->save();
            }

        $attachment = new Attachment();
        $attachment->attachment_name = $request->attachment_name;
        $attachment->file = $filename;
        $attachment->attachmentable_id = $request->segment_id;
        $attachment->attachmentable_type =  $noteable_type;
        $attachment->save();

        return $attachment;

    }



}
