<?php

namespace App\Http\Controllers\v1;

use App\Models\Booking;
use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Leave a review for a business service
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Booking $booking, Request $request)
    {
        // check booking belongs to user
        if (auth()->user()->id !== $booking->user_id)
            return $this->errorResponse(null, 'Unauthorized', 401);

        // validate request data
        $validation = Validator::make($request->only('comment', 'rating'), [
            'comment'   => 'required|string|max:150',
            'rating'    => 'required|numeric'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            
            Review::create([
                'user_id'       => $booking->user_id,
                'business_id'   => $booking->business_id,
                'comment'       => $request->comment,
                'rating'        => $request->rating
            ]);

            return $this->successResponse(null, 'Business review was successful', 201);
        
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
