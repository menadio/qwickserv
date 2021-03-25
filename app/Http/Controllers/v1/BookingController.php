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
     * Get user booking reservations collection 
     * 
     * @return \Illuminate\Http\Response
     */
    public function reserved()
    {
        try {
            
            $reservations = auth()->user()->reservedBookings;

            return $this->successResponse(
                BookingResource::collection($reservations),
                'Retrieved reservations successfully'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Get user active bookings collection
     * 
     * @return \Illuminate\Http\Response
     */
    public function active()
    {
        try {
            
            $activeBookings = auth()->user()->activeBookings;
    
            return $this->successResponse(
                BookingResource::collection($activeBookings),
                'Retrieved active booking reservation successfully'
            );
            
        } catch (\Exception $e) {

            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Get user completed bookings collection
     * 
     * @return \Illuminate\Http\Response
     */
    public function completed()
    {
        try {
            
            $completedBookings = auth()->user()->completedBookings;

            return $this->successResponse(
                BookingResource::collection($completedBookings),
                'Retrieved completed bookings successfully'
            );
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Show a booking reservation details
     * 
     * @param Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        try {
            
            if (auth()->user()->id !== $booking->user_id)
                return $this->errorResponse(null, 'Unauthorized', 401);

            return $this->successResponse(
                new BookingResource($booking),
                'Retreived booking reservation successfully'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Make service payout to artisan
     * 
     * @param Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function releasePay(Booking $booking)
    {
        try {
            
            if (auth()->user()->id !== $booking->user_id)
                return $this->errorResponse(null, 'Unauthorized', 401);

            // get status completed
            $completed = Status::where('name', 'Completed')->pluck('id')->first();

            // calculate charge
            $charge = $booking->fee * ( 5 / 100 );

            $booking->charge    = $charge;
            $booking->payout    = $booking->fee - $charge;
            $booking->status_id = $completed;

            $booking->save();

            return $this->successResponse(
                new BookingResource($booking),
                'Payout was successful'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
