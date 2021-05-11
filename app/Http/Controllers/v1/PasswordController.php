<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    /**
     * Send a password reset link
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLink(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->only('email'), [
            'email' => 'required|email'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === 'passwords.user')
                return $this->errorResponse(null, 'We can\'t find a user with that email address.', 400);

            return $this->successResponse(null, 'We have emailed your password reset link!');

        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Reset user password
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required|min:8',
            'token'     => 'required'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            
            $status = Password::reset(
                $request->only('email', 'password', 'token'),
                function ($user, $password) use ($request) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ]);
    
                    $user->save();
                }
            );

            if ($status === "passwords.token")
                return $this->errorResponse(null, 'This password reset token is invalid.');

            return $this->successResponse(null, 'Your password has been reset!');

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
