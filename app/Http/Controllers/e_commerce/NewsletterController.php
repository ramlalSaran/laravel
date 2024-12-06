<?php

namespace App\Http\Controllers\e_commerce;

use App\Models\NewsLetter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsletterController extends Controller
{
    function store(Request $request){
        $validate = $request->validate([
            'email' => 'required|email|unique:newsletters,email'
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already subscribed to our newsletter.',
        ]);
        
        NewsLetter::create($validate);
        return back()->with('success','Thenks For Subscribe');

    }
}
