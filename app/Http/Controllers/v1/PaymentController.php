<?php

namespace App\Http\Controllers\v1;

use App\Http\Resources\PaymentResource;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Status;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Make payment for a booked service
     * 
     * @param Booking $booking
     * @return \Illuminate\Http\Response
     */
    public function makePayment(Booking $booking)
    {
        try {

            // check for authorization
            $user = auth()->user();

            if ($user->id !== $booking->user_id)
                return $this->errorResponse(null, 'Unauthorized', 401);

            // check if booking payment already exist
            $payment = Payment::where([
                ['user_id', $user->id],
                ['booking_id', $booking->id]
            ])->first();

            if ($payment && $payment->status_id === 7) {

                // generate new reference
                $payment->reference = $this->getUniqueReference();
                $payment->save();

                return $this->successResponse(
                    new PaymentResource($payment),
                    'Payment initiated'
                );
            } else if ($payment && $payment->status_id !== 7) {

                return $this->successResponse(
                    null,
                    'Payment has been completed'
                );
            }

            $pending = Status::where('name', 'Pending')
                ->pluck('id')->first();
            
            $payment = Payment::create([
                'user_id'       => $booking->user_id,
                'business_id'   => $booking->business_id,
                'booking_id'    => $booking->id,
                'reference'     => $this->getUniqueReference(),
                'status_id'     => $pending
            ]);

            return $this->successResponse(
                new PaymentResource($payment),
                'Payment initiated'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Handle payment response
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function webhook(Request $request)
    {
        try {
            
            if ($request->event !== 'charge.success') exit();
    
            $ref = $request['data']['reference'];
            $amount = $request['data']['amount'] / 100;
            $charge = $amount * ( 2 / 100 );
    
            // check if payment
            $payment = Payment::where('reference', $ref)->first();
    
            if (!$payment) exit();
    
            $booking = Booking::find($payment->booking_id);
    
            if (!is_null($booking->fee)) exit();
    
            $booking->fee = $amount;
    
            $booking->charge = $charge;
    
            $booking->payout = $amount - $charge;
    
            $booking->save();
    
            return $this->successResponse(null);       

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

        }
    }
}
