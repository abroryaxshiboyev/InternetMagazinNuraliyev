<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $request->validated();

        $user=User::where('email',$request->email)->first();


        if(!$user || !Hash::check($request->password,$user->password)){
            return 'error';
        }

        $token=$user->createToken($request->email)->plainTextToken;

        return response()->json([
            'token' => $token
        ]);

    }

    public function logout(){
        
    }
    public function register(){
        
    }

    public function user(Request $request){
            return $request->user();
    }
}
