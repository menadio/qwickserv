<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Business;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /**
     * Place booking reservation
     * 
     * @param Business $business
     * @return \Illuminate\Http\Response
     */
    public function reserve(Business $business)
    {
        dd($business);
        // check business status
        if (!$this->isApproved($business))
            return $this->errorResponse(null, 'Currently not accepting bookings', 400);

        // place business service reservation
        try {
            
            $reserved = Status::where('name', 'Reserved')->pluck('id')->first();

            $booking = Booking::create([
                'user_id'       => auth()->user()->id,
                'business_id'   => $business->id,
                'status_id'     => $reserved
            ]);

            return $this->successResponse(
                new BookingResource($booking),
                'Placed reservation successfully',
                201
            );
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
        
    }
}
