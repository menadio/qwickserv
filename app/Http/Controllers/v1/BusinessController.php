<?php

namespace App\Http\Controllers\v1;

use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BusinessProfileResource;
use App\Http\Resources\BusinessViewResource;
use App\Http\Resources\ReviewResource;
use App\Jobs\UpdateBusinessViewsCount;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
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
            new BusinessProfileResource($user->business->load('photos', 'businessHours', 'businessBank')), 
            'Retrieved business successfully.'
        );
    }

    /**
     * Upload business logo
     * 
     * @param Business $business
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function uploadLogo(Business $business, Request $request)
    {
        if (auth()->user()->id !== $business->user_id)
            return $this->errorResponse(null, 'You are not authorized', 401);
            
        // validate request data
        $validation = Validator::make($request->only('logo'), [
            'logo'  => 'required|mimes:png,jpg'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {

            // delete logo if it exist
            if ( ! is_null($business->logo) ) {

                Storage::disk('public')->delete($business->logo);

                $business->logo = null;
                $business->save();

            }

            //  upload new business logo
            $filename = now()->timestamp . '.' . $request->logo->extension();

            $path = $request->file('logo')->storeAs('businesses/logos', $filename, 'public');

            $business->logo = $path;
            $business->save();

            return $this->successResponse(
                new BusinessProfileResource($business),
                'Business logo upload was successful'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
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
            'cover' => 'required|mimes:jpg,png'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {

            // delete cover if it exist
            if ( ! is_null($business->cover) ) {

                Storage::disk('public')->delete($business->cover);

                $business->cover = null;
                $business->save();

            }
            
            // upload new business cover photo
            $filename = now()->timestamp . '.' . $request->file('cover')->extension();

            $path = $request->file('cover')->storeAs('businesses/covers', $filename, 'public');

            $business->cover = $path;

            $business->save();

            return $this->successResponse(
                new BusinessProfileResource($business->load('photos', 'businessHours')),
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
            'phone'         => 'string'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {

            $business->update($request->all());

            return $this->successResponse(
                new BusinessProfileResource($business->load('businessHours')),
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
            UpdateBusinessViewsCount::dispatch($business)->delay(now()->addMinutes(2));
    
            return $this->successResponse(
                new BusinessViewResource($business->load('photos', 'businessHours', 'reviews')),
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
     * Get all open bookings for a business
     * 
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function bookings(Business $business)
    {
        try {
            
            if (auth()->user()->id !== $business->user_id)
                return $this->errorResponse(null, 'Unauthorized', 401);

            return $this->successResponse(
                BookingResource::collection($business->bookings),
                'Successfully retrieved business bookings'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Get all completed bookings for a business
     * 
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function completed(Business $business)
    {
        try {
            
            if (auth()->user()->id !== $business->user_id)
                return $this->errorResponse(null, 'Unauthorized', 401);

            return $this->successResponse(
                BookingResource::collection($business->completedBookings),
                'Successfully retrieved business completed bookings'
            );
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Get all reviews of a business
     * 
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function reviews(Business $business)
    {
        try {
            
            if (auth()->user()->id !== $business->user_id)
                return $this->errorResponse(null, 'Unauthorized', 401);

            return $this->successResponse(
                ReviewResource::collection($business->reviews),
                'Successfully retrieved business reviews'
            );
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Filter business by category
     * 
     * 
     */
    public function filtered(Category $category)
    {
        try {

            $category = Category::find($category->id);
            
            if ( is_null($category) )
                return $this->errorResponse(null, 'Category not found', 404);
            
            $businesses = Business::all();
    
            $filtered = $businesses->filter(function ($business) use ($category) {
                return  $business->category_id === $category->id;
            });
    
            return $this->successResponse(
                BusinessResource::collection($filtered->all()),
                'Retrieved businesses successfully'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
