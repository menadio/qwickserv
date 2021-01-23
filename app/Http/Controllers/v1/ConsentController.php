<?php

namespace App\Http\Controllers\v1;

use Exception;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ConsentController extends Controller
{
    /**
     * Accept terms of use
     * 
     * @return \Illuminate\Http\Response
     */
    public function accept()
    {
        try {
            
            // get authenticated user
            $user = auth()->user();

            $user->consent = true;
            $user->save();

            return $this->successResponse(
                new UserResource($user),
                'Terms of use accepted.'
            );

        } catch (Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Do not accept terms of use
     * 
     * @return \Illuminate\Http\Response
     */
    public function reject()
    {
        try {
            
            // get authenticated user
            $user = auth()->user();

            $user->consent = false;
            $user->save();

            return $this->successResponse(
                new UserResource($user),
                'Terms of use rejected.'
            );

        } catch (Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
