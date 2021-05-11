<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\Status;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Get collection of service resources
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = Status::where('name', 'Active')->pluck('id')->first();

        $services = Service::where('status_id', $active)->orderBy('name')->get();

        return $this->successResponse(
            ServiceResource::collection($services), 
            'Retrieved collection of services successfully'
        );
    }
}
