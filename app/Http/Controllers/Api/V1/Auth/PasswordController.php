<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\OtpVerifyRequest;
use App\Http\Requests\Api\V1\Auth\PasswordResetRequest;
use App\Http\Requests\Api\V1\Auth\SendOtpRequest;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    public function forgotPasswordOtpSend(SendOtpRequest $request)
    {
        try{
            $otp = rand(100000, 999999);
            PasswordResetOtp::updateorCreate([
                'email' => $request->email,
            ], [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
            ]);

            Mail::raw("Your otp is $otp. Otp expire in 10 minutes", function ($message) use ($request) {
                $message->to($request->email)->subject('Your otp');
            });

            return $this->success(null, 'Otp send successful to you email');
        }catch(\Exception $e){
            Log::error('Otp send error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);
        }
    }


    public function forgotPasswordVerify(OtpVerifyRequest $request)
    {
        try{
            $record = PasswordResetOtp::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();
            if(!$record){
                return $this->error(['error' => 'Invalid otp'], 422);
            }
            if(Carbon::parse($record->expires_at)->isPast()){
                return $this->error(['error' => 'Otp expired'], 422);
            }
            return $this->success(null, 'Otp verified');
        }catch(\Exception $e){
            Log::error('Otp verify error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);
        }

    }

    public function resetPassword(PasswordResetRequest $request)
    {
        try{
            $record = PasswordResetOtp::where('email', $request->email)
                    ->where('otp', $request->otp)
                    ->first();
            if(!$record){
                return $this->error(['error' => 'Invalid otp'], 422);
            }
            if(Carbon::parse($record->expires_at)->isPast()){
                return $this->error(['error' => 'Otp expired'], 422);
            }

            $user = User::where('email',$request->email)->first();
            $user->password = $request->password;
            $user->save();

            $record->delete();
            return $this->success(null, 'Password reset successful');
        }catch(\Exception $e){
            Log::error('Password reset error'. $e->getMessage());
            return $this->error(['error' => $e->getMessage()], 422);
        }
    }
    
}
