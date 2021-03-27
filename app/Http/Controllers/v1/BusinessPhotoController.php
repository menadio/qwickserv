<?php

namespace App\Http\Controllers\v1;

use App\Models\Business;
use App\Http\Controllers\Controller;
use App\Models\BusinessPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BusinessPhotoController extends Controller
{
    /**
     * Upload business photos
     * 
     * @param Business $business
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Business $business, Request $request)
    {
        // check authorization
        if (auth()->user()->id !== $business->user_id)
            return $this->errorResponse(null, 'Sorry! You are not authorized', 401);

        // business photo limit
        $photoCount = $business->photos->count();

        if ($photoCount === 4)
            return $this->errorResponse(null, 'Your business can have only 4 photos at a time'); 

        // validate request data
        $validation = Validator::make($request->all(), [
            'photo'     => 'required|array|max:512'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            
            $photos = $request['photo'];

            foreach ($photos as $photo) {

                $filename = now()->timestamp . '.' . $photo->extension();

                $path = $photo->storeAs('businesses/photos', $filename, 'public');

                BusinessPhoto::create([
                    'business_id'   => $business->id,
                    'photo'         => $path
                ]);
            }

            return $this->successResponse(null, 'Uploaded photos successfully.', 201);
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }

    /**
     * Remove a business photo
     * 
     * @param Business $business
     * @param BusinessPhoto $photo
     * @return \Illuminate\Http\Response
     */
    public function delete(Business $business, BusinessPhoto $photo)
    {
        try {
            
            // dd ($photo->photo);

            $photo->delete();

            Storage::disk('public')->delete($photo->photo);

            return $this->successResponse(null, 'Photo removed successfully');

        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
