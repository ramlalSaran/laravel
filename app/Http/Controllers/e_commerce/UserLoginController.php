<?php

namespace App\Http\Controllers\e_commerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function loginForm()
    {
        return view('e-commerce.login.user_login');
    }
    public function loginPost(Request $request)
    {
        $request->validate([
            'email'              => 'required',
            'password'           => 'required|min:8'
        ], [
            'email.required'     => 'The email field is required.',
            'password.required'  => 'The password field is required.',
            'password.min'       => 'The password must be at least 8 characters.'
        ]);

        $data = $request->only('email','password');
        
        if (Auth::attempt($data)) 
        {
            return redirect()->route('home');
        }
        else{
            // dd('fsddf');
            return back()->with('error','User Not Found! Over Database');
        }
    }
    public function Userlogout()
    {
        Auth::logout();
        return redirect()->route('login_form')->with('success','user Log-Out');
    }
}
 