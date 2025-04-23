<?php
 
namespace Auth\Application\Http\Controllers;

use Illuminate\Http\Request;

# use Auth\Application\Http\Requests\LoginRequest.php

use Illuminate\Support\Facades\Response;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;
use Auth\Application\Models\User;
use Auth\Application\Models\ApplicationUser;

use Illuminate\View\View;
 
class LoginController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function dashboard(/* LoginRequest $loginRequest */): View
    {
        /*
            Validate the user credentials (user name,email,password) using $loginRequest against the user table in the database 
            
            If the validation returns false, redirect the user to the login page and display error messages

            If the validation returns true: 
                1. Authenticate the user
                2. Retrieve the ApplicationUser model for the authenticated user
                3. Check if his/her 'active' field value is set to true or false (if set to false, log him/her out and redirect
                him/her to to the login page)
                4. Get his/her role id  
                5. If he/she is an employee (role_id = 1,2,3), redirect him/her to the employee dashboard.
                6. If he/she is an admin (role_id = 4), redirect him/her to the admin dashboard.
        */
    }

    public function logout():  RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();

        return view('auth.login');
    }

}