<?php

namespace App\Http\Controllers\Auth;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Vender;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if(!file_exists(storage_path() . '/installed'))
        {
            header('location:install');
            die;
        }

        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if($user->is_active == 0)
        {
            auth()->logout();
        }
    }

    public function showLoginForm($lang = 'en')
    {
        \App::setLocale($lang);

        return view('auth.login', compact('lang'));
    }

    public function showLinkRequestForm($lang = 'en')
    {
        \App::setLocale($lang);

        return view('auth.passwords.email', compact('lang'));
    }
}
