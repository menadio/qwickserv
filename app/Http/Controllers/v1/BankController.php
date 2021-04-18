<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankResource;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Get a collection of banks
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::all();
        
        return $this->successResponse(
            BankResource::collection($banks),
            'Retrieved a collection of banks'
        );
    }
}
