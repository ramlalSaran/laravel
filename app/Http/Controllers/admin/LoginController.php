<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('admin.login.index');
    }
    public function loginPost(Request $request){
        $request->validate([
            'email'             => 'required|email',
            'password'          => 'required|min:8',
        ],[
            'email.required'    => 'Email is a required field',
            'email.email'       => 'Please provide a valid email address',
            'password.required' => 'Password is a required field',
            'password.min'      => 'Password must be at least :min characters long.'
        ]);

        $valid=$request->only('email','password');

        if (Auth::attempt($valid)) 
        {
            if (Auth::user()->is_admin == 1) {
                
                return \redirect()->route('dashboard.index')->with('success','you are login');
            }else{
                return \redirect()->route('login')->with('error','Sorry ! You are not a admin ');
            }     
        }
        else{
            return \redirect()->route('login')->with('error','This is Not  admin Email & Password Please Valid Email and password 🤷‍♂️ Enter !');
        }
        
    }
    public function logout(){
        Auth::logout();
        return \redirect()->route('login')->with('error','you are logout');
    }
    
}
