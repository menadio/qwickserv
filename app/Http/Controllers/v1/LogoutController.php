<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Revoke authenticated user access token
     * 
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {

        auth()->user()->tokens()->delete();

        return $this->successResponse();

    }
}
