<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Jobs\UpdateBusinessSearchCount;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    /**
     * Run a search
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            
            $businesses = Business::search($request->search)->get();
    
            UpdateBusinessSearchCount::dispatch($businesses)->delay(now()->addMinutes(2));
    
            return $this->successResponse(
                BusinessResource::collection($businesses)
            );
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
