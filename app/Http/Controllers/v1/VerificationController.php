<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    /**
     * Verify a registered email account
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->only('otp'), [
            'otp'   => ['required', 'integer']
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Validation failed.', 422);

        try {

            $user = auth()->user();
            
            if (intval($request->otp) !== $user->otp) {

                return $this->errorResponse(null, 'Invalid OTP.');

            } else {

                // verify user email
                $user->email_verified_at = now()->toDateTimeString();
                $user->save();
    
                return $this->successResponse(
                    new UserResource($user), 
                    'Email verified.'
                );

            }

            
        } catch (Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Resend user OTP
     * 
     * @param \Illuminate\Http\Response
     */
    public function resend()
    {
        try {
            
            $user = auth()->user();

            $user->otp = rand(100000, 999999);
            $user->save();

            // queue OTP notification

            return $this->successResponse(null, 'Verification code has been sent to your registerd email.');

        } catch (Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
