<?php

namespace App\Http\Controllers\v1;

use App\Models\Business;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
    public function update(Business $business, Request $request)
    {
        dd ($request);

        // validate request data
        $validation = Validator::make($request->all(), [
            'opens_at'  => ['required'],
            'closes_at' => ['required']
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        $businessHours = $business->businessHours;

    }
}
