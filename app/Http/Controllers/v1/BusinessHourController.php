<?php

namespace App\Http\Controllers\v1;

use App\Models\BusinessHour;
use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessHourController extends Controller
{
    /**
     * Update business hours
     * 
     * @param App\Models\Business $business
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(BusinessHour $businesshour, Request $request)
    {
        // validate request data
        $validation = Validator::make($request->all(), [
            'opens_at'  => ['required', 'date_format:H:i'],
            'closes_at' => ['required', 'date_format:H:i']
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            
            $businesshour->update($request->only('opens_at', 'closes_at'));

            return $this->successResponse(
                new BusinessResource($businesshour->business->load('businessHours')),
                'Business hour update successful'
            );
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
