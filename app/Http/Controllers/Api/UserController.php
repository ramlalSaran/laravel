<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request){
        $validateUser = Validator::make(
            $request->all(),
            [
                'email'    => 'required|email',
                'password' => 'required'
            ]
            );
            if ($validateUser->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validation error',
                    'data'     => $validateUser->errors()->all()
          
                ],401);
            }
          if (Auth::attempt(['email' => $request->email , 'password' => $request->password])) {
            $user = Auth::user();
                return response()->json([
                    'status'         => true,
                    'message'        =>'User login SuccessFully',
                    'token'          => $user->createToken("Api Token")->plainTextToken,
                    'token_type'     => 'bearer'
        
                ],200);
          } else{
            return response()->json([
                'status'  => false,
                'message' => 'User Not Found',
                // 'data' => $validateUser->errors()->all()
      
            ],401);
          } 
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->tokens()->delete();
        return response()->json([
            'status'  => true,
            'massage' => 'User Logout',
        ],200);
    }
}
