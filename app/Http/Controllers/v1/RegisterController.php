<?php

namespace App\Http\Controllers\v1;

use App\Events\BusinessCreated;
use Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\UserResource;
use App\Models\AccountType;
use App\Models\Business;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Create a new individual account
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function individual(Request $request)
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

            $acountType = AccountType::where('name', 'Individual')->first();
            $pending = Status::where('name', 'Pending')->pluck('id')->first();
            
            // create individual user account
            $user = User::create([
                'first_name'        => ucfirst($request->firstname),
                'last_name'         => ucfirst($request->lastname),
                'phone'             => $request->phone,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'otp'               => rand(100000, 999999),
                'account_type_id'   => $acountType->id,
                'status_id'         => $pending
            ]);

            if ($user) {

                // queue register notification

                // grant user access token
                $token = $user->createToken('qwickserv')->plainTextToken;

                return response()->json([
                    'success'       => true,
                    'accessToken'   => $token,
                    // 'data'          => new UserResource($user),
                    'message'       => 'Yaay! Your account has been created.'
                ]);
                
            }
            
        } catch (Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Create a new business account
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function business(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->all(), [
            'name'          => ['required', 'string'],
            'phone'         => ['required', 'string'],
            'email'         => ['required', 'email:rfc,dns', 'unique:users'],
            'password'      => ['required'],
            'category_id'   => ['required', 'integer'],
            'logo'          => ['mimes:png']
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Validation failed.', 422);

        try {

            $acountType = AccountType::where('name', 'Business')->first();
            $active = Status::where('name', 'Active')->first();
            $unapproved = Status::where('name', 'Unapproved')->first();

            // create business user account
            $user = User::create([
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'otp'               => rand(100000, 999999),
                'account_type_id'   => $acountType->id,
                'status_id'         => $active->id
            ]);
                
            // create business record
            if ($user) {
                
                $business = Business::create([
                'user_id'       => $user->id,
                'name'          => ucwords($request->name),
                'phone'         => $request->phone,
                'category_id'   => $request->category_id,
                'status_id'     => $unapproved->id
            ]);

            if ($request->logo) {

                $filename = now()->timestamp . '.' . $request->logo->extension();

                $path = $request->file('logo')->storeAs('businesses/logos', $filename, 'public');

                $business->logo = $path;
                $business->save();
            }

            // store business services
            foreach ($request->services as $service) {

                $business->services()->attach($service);
            }

            // grant user access token
            $token = $user->createToken('qwickserv')->plainTextToken;

            return response()->json([
                'success'       => true,
                'message'       => 'Yaay! Your account has been created.',
                'accessToken'   => $token,
                'data'          => new BusinessResource($business->load('services', 'businessHours'))
            ], 201);

            }
            
        } catch (Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
