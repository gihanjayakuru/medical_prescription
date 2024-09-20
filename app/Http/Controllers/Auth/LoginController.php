<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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
    protected function redirectTo()
    {
        // Check user role and redirect accordingly
        $role = Auth::user()->role;

        if ($role === 'pharmacy') {
            return '/pharmacy/prescriptions'; // Pharmacy users are redirected here
        } elseif ($role === 'user') {
            return '/user/prescriptions'; // Regular users are redirected here
        } else {
            Auth::logout(); // Log out users with unrecognized roles
            return '/login'; // Redirect to login if the role is unrecognized
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
}
