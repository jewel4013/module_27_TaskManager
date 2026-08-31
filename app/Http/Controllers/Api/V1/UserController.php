<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProfileUpdateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        try{
            return $this->success(new UserResource($request->user()), 'User Profile');
        }catch(\Exception $e){
            Log::error('Something Error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);
        }
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        try{
            $user = $request->user();
            $user->update($request->validated());
            return $this->success(new UserResource($user), 'User Profile Updated');
        }catch(\Exception $e){
            Log::error('Profile update Error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);
        }
    }

    public function logout(Request $request)
    {
        try{
            $user = $request->user()->tokens()->delete();
            return $this->success(null , 'Log out successful');
        }catch(\Exception $e){
            Log::error('Something Error'. $e->getMessage());
            return $this->error();
        }
    }

}
