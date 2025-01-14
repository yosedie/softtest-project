<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Socialite;
use App\User;
use Illuminate\Support\MessageBag;
use Spatie\Activitylog\Contracts\Activity;
use App\Setting;
use Illuminate\Http\Request;



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
    public function showLoginForm()
    {
        $setting = Setting::first();
        if($setting->theme == '1'){
            return view('auth.login');
            }
        return view('theme_2.front.auth.login'); // Adjust if your view is in a different path
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = Auth::user(); // Get the authenticated user

            // Handle additional logic after successful login
            return $this->authenticated($request, $user) ?: redirect()->intended($this->redirectPath());
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user's login credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return Auth::attempt($this->credentials($request), $request->filled('remember'));
    }

    /**
     * Get the login credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Handle a successful login attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function authenticated(Request $request, $user)
    {
        $gsetting = Setting::first();

        // Check if activity logging is enabled
        if (isset($gsetting->activity_enable) && $gsetting->activity_enable == '1') {
            activity()
                ->useLog('Login')
                ->performedOn($user)
                ->causedBy($user)
                ->withProperties(['customProperty' => 'Login'])
                ->log('Logged In')
                ->subject('Login');
        }

        // Check if the user's account is active
        if ($user->status == 1) {
            if ($user->role == "admin") {
                return redirect()->route('admin.index');
            } elseif ($user->role == "instructor") {
                return redirect()->route('instructor.index');
            } elseif ($user->getRoleNames()[0] != 'user') {
                return redirect()->route('admin.index');
            } else {
                return redirect('/home');
            }
        } else {
            // Log the user out if their account is deactivated
            Auth::logout();
            return redirect()->route('login')->with('delete', 'You are deactivated!');
        }
    }

    /**
     * Handle a failed login attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()->withErrors([
            'email' => trans('auth.failed'),
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * Get the path to redirect users after login.
     *
     * @return string
     */
    protected function redirectPath()
    {
        return '/home'; // Adjust this path as needed
    }
    
    
    /**
     * Handle user redirection after login based on role and status.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleRedirection(User $user)
    {
        
        // Check if the user is active
        if ($user->status == 1) {
            // Redirect based on the user's role
            if ($user->role == "admin") {
                return redirect()->route('admin.index');
            } elseif ($user->role == "instructor") {
                return redirect()->route('instructor.index');
            } elseif ($user->getRoleNames()[0] != 'user') {
                return redirect()->route('admin.index');
            } else {
                return redirect('/home');
            }
        } else {
            Auth::logout();
            return redirect()->route('login')->with('delete', 'You are deactivated!');
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function handleProviderCallback($social)
    {
        $userSocial = Socialite::driver($social)->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();

        // set the remember me cookie if the user check the box
        $remember = $request->has('remember') ? true : false;

        // attempt to do the login
       
        if(Auth::attempt(['email' => $request->get('email') , 'password' => $request->get('password') ,
        'status' => 1], $remember)){
        
                return redirect()->intended('/home');
        }
        else
        {
            $errors = new MessageBag(['email' => ['Email or password is invalid.']]);
            return Redirect::back()->withErrors($errors)->withInput($request->except('password'));
        }



        if ($user) {
            Auth::login($user);
            return redirect()-> action('HomeController@index');
        }
        else {
            return view('auth.register', ['name'=> $userSocial->getName(), 
                                            'email' => $userSocial->getEmail()]);
        }
    }

    function custom_login()
    {
        $setting = Setting::first();

        if($setting->theme == '1')
        {
            return view('auth.login');
        }  else {
            return view('theme_2.front.auth.login');
        }
    }

    
}
