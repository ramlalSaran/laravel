<?php

namespace App\Http\Controllers\admin;

use App\Mail\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    function sendEmail(){
       $to  = "ramlalsaranofficial@gmail.com";
       $msg = "Test Email" ;
       $sub = 'Tesing Email sending'; 
       Mail::to($to)->send(new Email($msg,$sub));
    }
    
}
