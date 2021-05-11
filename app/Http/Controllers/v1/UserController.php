<?php

namespace App\Http\Controllers\v1;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\UserResource;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Retrieve user's profile
     * 
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        try {

            $user = auth()->user();

            return $this->successResponse(
                new UserResource($user),
                'Retrieved user profile successfully'
            );
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Upload profile picture
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response
     */
    public function updateProfileImage(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->only('photo'), [
            'photo' => 'required|file|mimes:png,jpg|max:512'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {

            $user = auth()->user();
            
            $filename = now()->timestamp . '.' . $request->file('photo')->extension();

            $path = $request->file('photo')->storeAs('users/photos', $filename, 'public');

            $user->profile_image = $path;

            $user->save();

            return $this->successResponse(
                new UserResource($user),
                'Profile image updated successfully'
            );
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Update user resource
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            
            $user = auth()->user();

            $user->update($request->all());

            return $this->successResponse(
                new UserResource($user),
                'Updated user profile successfully'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Get businesses close by
     * 
     * @return \Illuminate\Http\Response
     */
    public function nearBy()
    {
        try {
            
            // return business near a user ordered by business rating
            $businesses = Business::inRandomOrder()
                ->limit(2)->get();
                // ->orderByDesc('avg_rating')->limit(2)->get();
            return $this->successResponse(
                BusinessResource::collection($businesses),
                'Retrieved near by businesses successfully'
            );
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
