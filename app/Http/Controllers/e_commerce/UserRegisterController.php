<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserRegisterController extends Controller
{
    public function registerForm()
    {
        return  view('e-commerce.register.user_register');
    }

    public function registerPost(Request $request)
    {
        
        $request->validate([
            'name'                       => 'required|string|max:255',
            'email'                      => 'required|email|unique:users,email|max:255',
            'phone'                      => 'required',
            'password'                   => 'required|string|min:8',
            'retype_password'            => 'required|same:password',
            'gender'                     => 'required'
        ], [
            'name.required'              => 'Name is required.',
            'email.required'             => 'Email is required.',
            'email.email'                => 'Please provide a valid email address.',
            'email.unique'               => 'This email is already registered.',
            'phone.required'             => 'Phone number is required.',
            'password.required'          => 'Password is required.',
            'password.min'               => 'Password must be at least 8 characters.',
            'password.confirmed'         => 'Passwords do not match.',
            'retype_password.required'   => 'You must retype your password.',
            'retype_password.same'       => 'The passwords must match.',
            'gender.required'            => 'Gender selection is required.',
        ]);

        $user = User::create([
        'name'                           => $request->name,
        'email'                          => $request->email,
        'phone'                          => $request->phone,
        'password'                       => Hash::Make($request->password),
        'gender'                         => $request->gender

        ]);

        if ($user) 
        {
            $emailsend = User::where('id',$user->id)->first();
            Mail::to($emailsend->email)->send(new WelcomeMail($emailsend));
            return redirect()->route('login_form')->with('success','Account Create Now User Login');
        }
        else{
            return back()->with('error','User not create some thing error');
        }
    }
}
