<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
     * Store new business category
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->all(), [
            'name'          => 'required|string|max:30',
            'description'   => 'required|string|max:150',
            'icon'          => 'required|mimes:svg',
            'status'        => 'required|numeric|min:1'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            
            $filename = now()->timestamp . '.' . $request->file('icon')->extension();
    
            $path = $request->file('icon')->storeAs('businesses/categories', $filename, 'public');
    
            $category = Category::create([
                'name'  => $request->name,
                'description'   => $request->description,
                'icon'  => $path,
                'status_id' => 1
            ]);
    
            return $this->successResponse(
                new CategoryResource($category),
                'New business category created',
                201
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
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

    /**
     * Update a category
     * 
     * @param Category $category
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category, Request $request)
    {
        // validate request data
        $validation = Validator::make($request->only('name', 'description', 'icon', 'status'), [
            'name'  => 'string|max:30',
            'description'   => 'string|max:150',
            'icon'  => 'mimes:svg',
            'status'    => 'numeric|min:1'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            
            $category->update($request->all());

            if ($request->has('icon')) {

                $filename = now()->timestamp . '.' . $request->file('icon')->extension();

                $path = $request->file('icon')->storeAs('businesses/categories', $filename, 'public');

                $category->update(['icon' => $path]); 

            }

            return $this->successResponse(
                new CategoryResource($category),
                'Category was updated successfully'
            );

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
