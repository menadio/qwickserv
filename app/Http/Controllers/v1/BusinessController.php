<?php

namespace App\Http\Controllers\v1;

use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\BusinessViewResource;
use App\Models\Booking;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    /**
     * Get a business resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth()->user();

        if (!$user->business)
            return $this->errorResponse(null, 'You do not own a business.');

        return $this->successResponse(
            new BusinessResource($user->business->load('photos', 'services', 'businessHours')), 
            'Retrieved business successfully.'
        );
    }

    /**
     * Upload a business cover image
     * 
     * @param Business $business
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function uploadCover(Business $business, Request $request)
    {
        // check authorization
        if (auth()->user()->id !== $business->user_id)
            return $this->errorResponse(null, 'Sorry! You are not authorized', 401);

        // validate request data
        $validation = Validator::make($request->only('cover'), [
            'cover' => 'required|file|mimes:jpeg,png'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            
            $filename = now()->timestamp . '.' . $request->file('cover')->extension();

            $path = $request->file('cover')->storeAs('businesses/covers', $filename, 'public');

            $business->cover = $path;

            $business->save();

            return $this->successResponse(
                new BusinessResource($business->load('photos', 'services', 'businessHours')),
                'Business cover uplaoded successfully'
            );
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Update a business resource
     * 
     * @param Business $business
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Business $business, Request $request)
    {
        // check if authenticated user owns the business
        if (auth()->user()->id !== $business->user_id)
            return $this->errorResponse(null, 'Sorry! Your are not authorized', 401);

        // validate request data
        $validation = Validator::make($request->all(), [
            'name'          => 'string',
            'address'       => 'string',
            'logo'          => 'mimes:png',
            'cover'         => 'mimes:jpeg,png',
            'description'   => 'string',
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            // update business 
            

            return $this->successResponse(
                new BusinessResource($business->load('services', 'businessHours')),
                'Business record updated successfully'
            );
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Show a business details
     * 
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        try {
            // get approved status
            $approved = Status::where('name', 'Approved')->pluck('id')->first();

            if ($business->status_id !== $approved)
                return $this->errorResponse(null, 'Business is currently ' . strtolower($business->status->name));
            
            // update business views count
            self::incrementViews($business);
    
            return $this->successResponse(
                new BusinessViewResource($business->load('photos', 'services', 'businessHours')),
                'Retrieved business successfully.'
            );
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Book a business service
     * 
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function reserve(Business $business)
    {
        try {
            // check if business approved
            if (! $this->isApproved($business))
                return $this->errorResponse( 
                    null, 
                    'Business is currently ' . strtolower($business->status->name)
                );

            // check if authenticated user owns business
            $user = auth()->user();

            if ( $user->id === $business->user_id)
                return $this->errorResponse(
                    null,
                    'Business is owned by you.'
                );

            // get reserved status
            $reserved = Status::where('name', 'Reserved')->pluck('id')->first();
            
            $booking = Booking::create([
                'user_id'       => auth()->user()->id,
                'business_id'   => $business->id,
                'status_id'     => $reserved
            ]);

            if ($booking)
                return $this->successResponse(
                    null,
                    'Booking reservation was successful.',
                    201
                );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Update the number of times a business resource
     * has been viewed
     * 
     * @return void
     */
    private static function incrementViews($business)
    {
        $business->views_count++;

        $business->save();
    }
}
