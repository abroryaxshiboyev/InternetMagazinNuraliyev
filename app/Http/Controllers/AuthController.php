<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected FileService $fileService
    ) {}
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        $this->authService->checkCredentials($user, $request);

        return $this->success(data: ['token' => $user->createToken($request->email)->plainTextToken]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success('user logged out');
    }
    public function register(RegisterRequest $request)
    {
        $inputs = $request->validated();
        $inputs['password'] = Hash::make($request->password);
        $user = User::create($inputs);
        $user->assignRole('customer');

        $this->fileService->checkUserPhoto($user,$request);

        return $this->success('user created successfully', ['token' => $user->createToken($request->email)->plainTextToken]);
    }

    public function changePassword() {}
    public function user(Request $request): JsonResponse
    {
        return $this->response(new UserResource($request->user()));
    }
}
