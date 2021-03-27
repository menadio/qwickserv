<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Authenticate existing user
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->only('email', 'password'), [
            'email'     => ['required', 'email:rfc,dns'],
            'password'  => ['required']
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Validation failed.', 422);

        try {
            
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password))
                return $this->errorResponse(null, 'The provided credentials are incorrect.', 400);

            $token = $user->createToken('qwickserv')->plainTextToken;
            
            $data = ($user->account_type === 1) ? $user : $user->load('business');

            return response()->json([
                'success'       => true,
                'accessToken'   => $token,
                'data'          => new UserResource($user),
                'message'       => 'Login successful.'
            ]);

        } catch (Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
