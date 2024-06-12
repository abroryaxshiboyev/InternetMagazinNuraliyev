<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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

        return $this->success(data:['token' => $token]);

    }

    public function logout(){
        
    }
    public function register(){
        
    }

    public function changePassword(){
        
    }
    public function user(Request $request):JsonResponse
    {
            return $this->response(new UserResource($request->user()));
    }
}
