<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        try {
            $user = User::create($request->validated());
            return $this->success(new UserResource($user), 'Registration Successful');
        }catch(\Exception $e){
            Log::error('Register Error: '.$e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);
        }
    }
}
