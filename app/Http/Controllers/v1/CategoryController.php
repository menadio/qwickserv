<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get a collection of all active categories
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active = Status::where('name', 'Active')->first();

        $categories = Category::where('status_id', $active->id)->get();

        return $this->successResponse(
            CategoryResource::collection($categories), 
            'Retreived categories successfully.'
        );
    }

    /**
     * Get a category resource
     * 
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->successResponse(
            new CategoryResource($category->load('services')),
            'Retrieved category resource successfully'
        );
    }
}
