<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessBankResource;
use App\Models\BusinessBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BusinessBankController extends Controller
{
    /**
     * Get business bank account details
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            // get authenticated user
            $user = auth()->user();

            $bankDetails = $user->business->businessBank;

            if (is_null($bankDetails)) {

                return $this->errorResponse(
                    null, 'Bank details does not exist. Please update bank details.', 404
                );
            }

            return $this->successResponse(
                new BusinessBankResource($bankDetails),
                'Retrieved business bank details successfully'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Store business bank details
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            
            // validate request data
            $validation = Validator::make($request->all(), [
                'bank_id'   => 'required | numeric',
                'account_name'  => 'required | string',
                'account_number'    => 'required'
            ]);

            if ($validation->fails())
                return $this->errorResponse(
                    $validation->errors(),
                    'Failed validation',
                    422
                );

            // store business account details
            $user = auth()->user();

            $business = $user->business;

            $bankDetails = BusinessBank::create([
                'business_id'       => $business->id,
                'bank_id'           => $request->bank_id,
                'account_name'      => $request->account_name,
                'account_number'    => $request->account_number
            ]);

            if ($bankDetails)
                return $this->successResponse(
                    new BusinessBankResource($bankDetails),
                    'Business bank details stored successfully',
                    201
                );
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
