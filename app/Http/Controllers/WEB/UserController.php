<?php

namespace App\Http\Controllers\WEB;

use App\User;

use App\Notifications\ResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Token;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Report;


use Image;
use Mail;

class UserController extends Controller
{

    //////////////////// User Home Page  //////////////////
    public function __invoke(){
        if(Auth::check()){
            return view('website.home.dashboard');    //Go To Dashboard if Auth::check() is True
        }else{
            return view('website.index');    //Login First if Auth::check() is False
        }  
    }
    ////////////////// End User Home Page  ////////////////


    public function sendInvoiceToClient($invoice_id){
        $invoice = Invoice::findOrFail($invoice_id);
        $client = Client::findOrFail($invoice->client_id);
        
            //$token = Password::broker()->createToken($user);

            $subject = __('website.invoice');
            
            $blade_data = array(
                'subject'=> $invoice->invoice_number,
                //'settings'=>$this->settings,
                'item' => $invoice,
            );
            $email_data = array(
                'from' => env('MAIL_FROM_ADDRESS'),
                'fromName' => env('MAIL_FROM_NAME'),
                'to' => [$client->email]);
            try{
                Mail::send('website.emails.sendInvoiceToClient', $blade_data, function ($message) use ($email_data, $subject) {
                    $message->to($email_data['to'])
                        ->subject($subject)
                        ->replyTo($email_data['from'], $email_data['fromName'])
                        ->from($email_data['from'],$email_data['fromName']);
    
                });
                return redirect()->back();
            }
            catch(Exception $e) {
               // do any thing
            }
        
        
    }



    public function sendReportToClient($report_id){
        $report = Report::findOrFail($report_id);
        $client = Client::findOrFail($report->client_id);
        
            //$token = Password::broker()->createToken($user);

            $subject = __('website.report');
            
            $blade_data = array(
                'subject'=> $report->id,
                //'settings'=>$this->settings,
                'item' => $report,
            );
            $email_data = array(
                'from' => env('MAIL_FROM_ADDRESS'),
                'fromName' => env('MAIL_FROM_NAME'),
                'to' => [$client->email]);
            try{
                Mail::send('website.emails.sendReportToClient', $blade_data, function ($message) use ($email_data, $subject) {
                    $message->to($email_data['to'])
                        ->subject($subject)
                        ->replyTo($email_data['from'], $email_data['fromName'])
                        ->from($email_data['from'],$email_data['fromName']);
    
                });
                return redirect()->back();
            }
            catch(Exception $e) {
               // do any thing
            }
        
        
    }


    //////////////////// Login User //////////////////
    public function loginuser(Request $request){
        
        
        $email = $request->get('email');
        $password = $request->get('password');
        $password =  bcrypt($password);

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {  //Email Or Password Error Validation
                return back()->withInput()->withErrors($validator);
        }
        else{
            if (Auth::attempt(['email' => request('email'), 'password' => request('password')], $request->remember)) {
                $user = Auth::user();
                if($user->status == 'active'){
                    return redirect('/');  //Go To Dashboard After User Loggin
                }
                elseif ($user->status == 'not_active') {  //User Not Active
                    Auth::logout();
                    return back()->withErrors(__('website.not_active_msg'));
                }
                else{
                    Auth::logout();
                    return back()->withErrors(__('website.not_active_msg'));
                }
            }
            else{
                return back()->withErrors(__('website.error_login')); //Email Or Password Not True
            }
        }
    }
    ////////////////// End Login User ////////////////




    ///////////////////// Logout User  ///////////////
    public function userlogout(){
        Auth::logout();
        return redirect('/'); 
    }
    /////////////////// End Logout User  /////////////


}
