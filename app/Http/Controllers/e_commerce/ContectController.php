<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\Review;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContectController extends Controller
{
    public function getform()
    {
        return view('e-commerce.contactUs.create');
    }

    public function contactPost(Request $request)
    {
        $validateData=$request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:enquiries,email',
            'phone' => 'required',
            'message' => 'required'
        ], [
            'name.required' => 'Name field is required',
            'email.required' => 'Email field is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email has already been taken',
            'phone.required' => 'Phone field is required',
            'message.required' => 'Message field is required'
        ]);

        Enquiry::create([
            'name'=>$validateData['name'],
            'email'=>$validateData['email'],
            'phone'=>$validateData['phone'],
            'message'=>$validateData['message'],
        ]);
        return redirect()->route('contact')->with('success','Thanks For Connection');
        
    }

    public function sendReview(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            
        ]);
        Review::create([
            'product_id'=>$request->product_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'rating'=>$request->rating,
            'review'=>$request->review
        ]);
        return redirect()->back();

    }
}
