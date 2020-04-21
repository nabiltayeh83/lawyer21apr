<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function loginuser(Request $request)
    {
        $this->validateLogin($request);
        $user = User::where('email',$request->email)->first();
        if($user){
            if($user->status != 'active'){
                $message = (app()->getLocale() == "ar") ? 'الحساب غير مفعل' : 'The account not active';
                return redirect()->back()->withErrors([$message]);
            }
        }
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }




    public function login(Request $request)
    {
        $this->validateLogin($request);
        $user = User::where('email',$request->email)->first();
        if($user){
            if($user->status != 'active'){
                $message = (app()->getLocale() == "ar") ? 'الحساب غير مفعل' : 'The account not active';
                return redirect()->back()->withErrors([$message]);
            }
        }
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }



    protected function redirectTo()
    {
        return '/dashboard';
    }



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user', ['except' => ['logout']]);
        
    }



    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        return redirect('/');
    }





}
