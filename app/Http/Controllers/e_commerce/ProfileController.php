<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function userProfile()
    {
        $user_id =  Auth::user()->id;
        $orders = Order::where('user_id', $user_id)
               ->with('items', 'addresses')
               ->get();
            //    dd($orders);

        // $orders = Order::; // Fetch 10 orders per page

        return view('e-commerce.profile.profile',compact('orders'));
    }

    public function changePass(Request $request)
    {
        $request->validate([
            'current_pass'            => 'required|min:8',
            'new_pass'                => 'required|min:8',
            'con_pass'                => 'required|same:new_pass',
        ],[
            'current_pass.required'   => 'Old password is required.',
            'current_pass.min'        => 'Old password must be at least 8 characters.',
            'new_pass.required'       => 'Password is a required field.',
            'new_pass.min'            => 'Password must be at least 8 characters.',
            'con_pass.required'       => 'Password confirmation is required.',
            'con_pass.same'           => 'Password confirmation must match the password.',
        ]);
        $user=Auth::user();
        if (!Hash::check($request->current_pass,$user->password)) 
        {
            return back()->with('error','Old Password Not Match');
        }else{
            $updatePass=[
                'password'=>Hash::make($request->new_pass)
            ];
            $user->update($updatePass);
            return redirect()->route('Userlogout');  
        }
    }

    public function userProfileUpdate(Request $request)
    {
       
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(), // Correctly formatted
            'phone' => 'required',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'phone.required' => 'The phone number is required.',
        ]);
        
        if (Auth::check() ) 
        {
            $user = Auth::user();
            $update = $user->update([
                'name'   => $request->name,
                'email'  => $request->email,
                'phone'  => $request->phone,
            ]);

            if ($update) 
            {
                return redirect()->route('userProfile')->with('success','Profile Update Successfully');
            }
            else{
                return back()->with('error','Profile Update Successfully');
            }
         
        }else{
            dd('No Profile');
        }    
    } 
}