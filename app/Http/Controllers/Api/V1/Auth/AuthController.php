<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->validated());
            return $this->success(new UserResource($user), 'Registration Successful');
        }catch(\Exception $e){
            Log::error('Register Error: '.$e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $user = User::whereEmail($request->email)->first();
            if(!$user || !Hash::check($request->password, $user->password)){
                return $this->error(['error' => 'Invalid Credentials'], 422);
            }

            $authToken = $user->createToken('authToken')->plainTextToken;
            $data = [
                'user' => new UserResource($user),
                'token' => $authToken
            ];

            return $this->success($data, 'Login Successful');
        }catch(\Exception $e){
            Log::error('Invalid Credentials'.$e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);
        }
    }
}
