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

class RegisterController extends Controller
{
    /**
     * Create a new user account
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->all(), [
            'firstname'     => ['required', 'string', 'max:25'],
            'lastname'      => ['required', 'string', 'max:25'],
            'phone'         => ['required', 'string'],
            'email'         => ['required', 'email:rfc,dns', 'unique:users'],
            'password'      => ['required']
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Validation failed.', 422);

        try {
            
            $user = User::create([
                'first_name'    => $request->firstname,
                'last_name'     => $request->lastname,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'password'      => Hash::make($request->password)
            ]);

            if ($user) {

                // queue register notification

                // grant user access token
                $token = $user->createToken('qwickserv')->plainTextToken;

                return response()->json([
                    'success'       => true,
                    'accessToken'   => $token,
                    'data'          => new UserResource($user),
                    'message'       => 'Yaay! Your account has been created.'
                ]);
                
            }
            
        } catch (Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
