<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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
            return $this->error('invalid email or password');
        }

        $token=$user->createToken($request->email)->plainTextToken;

        return $this->success(data:['token' => $token]);

    }

    public function logout(){
        
    }
    public function register(RegisterRequest $request)
    {
        $inputs=$request->validated();
        $inputs['password']=Hash::make($request->password);
        $user=User::create($inputs);
        $user->assignRole('customer');

        if($request->hasFile('photo'))
        {
            $path=$request->file('photo')->store('users/'.$user->id,'public');
            $user->photos()->create([
                'full_name' => $request->file('photo')->getClientOriginalName(),
                'path' => $path
            ]);
        }

        return $this->success('user created successfully',['token'=>$user->createToken($request->email)->plainTextToken]);
    }

    public function changePassword(){
        
    }
    public function user(Request $request):JsonResponse
    {
            return $this->response(new UserResource($request->user()));
    }
}
