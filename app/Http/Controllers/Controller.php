<?php

namespace App\Http\Controllers;

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
                'data'      => $data,
                'message'   => $message
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
                'error'         => $error,
                'message'       => $message
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
}
