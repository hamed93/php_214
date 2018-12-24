<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Events\UserActivation;
use Illuminate\Support\Facades\Auth;
use Socialite;


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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        if(auth()->validate($request->only('email','password')))
            {
               $user=User::whereEmail($request->input('email'))->first();
        
               if($user->active==0){
                       $checkActiveCode=$user->activationCode()->where('expire','>',Carbon::now())->latest()->first();
      
                           if(isset($checkActiveCode)){
                           if($checkActiveCode->expire>Carbon::now()){ 
                               $this->incrementLoginAttempts($request);
                               return back()->withErrors(['code'=>'ایمیل فعال سازی به شما ارسال شده است.بعد از 15 دقیقه اقدام کنید']);

        }
    }
        
    
               else {
                           event(new UserActivation($user));
                   }
}
}
 
     
       if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $social_user = Socialite::driver('google')->user();
        //dd($social_user);
        $user = User::whereEmail($social_user->getEmail())->first();


        if( ! $user ) {
            $user = User::create([
                'name' => $social_user->getName(),
                'email' => $social_user->getEmail(),
                'password' => bcrypt($social_user->getId())
            ]);
        }

        if($user->active == 0) {
            $user->update([
                'active' => 1
            ]);
        }

        auth()->loginUsingId($user->id);
        return redirect('/');

        return redirect('/');
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            //'g-recaptcha-response'=>'recaptcha'
        ]);
    }
    }
