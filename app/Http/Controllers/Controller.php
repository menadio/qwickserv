<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Status;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Send successful response
     * 
     * @param $data
     * @param $message
     * @return \Illuminate\Http\Response
     */
    public function successResponse($data = null, $message = 'Operation successful.', $httpCode = 200)
    {
        if (is_null($data)) {

            return response()->json([
                'success'   => true,
                'message'   => $message
            ], $httpCode);

        } else {

            return response()->json([
                'success'   => true,
                'message'   => $message,
                'data'      => $data
            ], $httpCode);

        }
    }

    /**
     * Send error response
     * 
     * @param $error
     * @param $message
     * @return \Illuminate\Http\Response
     */
    public function errorResponse($error = null, $message = null, $httpCode = 400)
    {
        if (is_null($error)) {

            return response()->json([
                'success'       => false,
                'message'       => $message
            ], $httpCode);

        } else {

            return response()->json([
                'success'       => false,
                'message'       => $message,
                'error'         => $error
            ], $httpCode);

        }
    }

    /**
     * Send server error response
     * 
     * @return \Illuminate\Http\Response
     */
    public function serverError()
    {
        return response()->json([
            'success'   => false,
            'message'   => 'Oops! That shouldn\'t happen, please try again later.'
        ], 500);
    }

    /**
     * Check if a business is approved
     * 
     * @param $business
     * @return bool
     */
    public function isApproved($business)
    {
        $approved = Status::where('name', 'Approved')->pluck('id')->first();

        if ($business->status_id === $approved) {

            return true;
        }
    }

    /**
     * Generate unique reference ids
     */
    public static function getUniqueReference($lenght = 20)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}
