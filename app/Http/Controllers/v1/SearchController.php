<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use Illuminate\Http\Request;

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
        $businesses = Business::search($request->search)->get();

        return $this->successResponse(
            BusinessResource::collection($businesses)
        );
    }
}
