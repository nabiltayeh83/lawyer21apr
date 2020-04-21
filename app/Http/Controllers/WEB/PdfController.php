<?php
namespace App\Http\Controllers\WEB;

use Illuminate\Http\Request;


use Redirect;
use PDF;



use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;





use Dotenv\Exception\ValidationException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use Auth;
use Session;

class PdfController extends Controller
{


    public function pdfForm()
    {
        return view('pdf_form');
    }


    public function pdfDownload(Request $request){

       request()->validate([
        'name' => 'required',
        'email' => 'required|email',
        'message' => 'required'
        ]);

         $data =
         [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
         ];
       $pdf = PDF::loadView('pdf_download', $data);

       return $pdf->download('tutsmake.pdf');
    }









}
