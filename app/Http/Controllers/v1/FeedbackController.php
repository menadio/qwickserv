<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Make a feedback
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request data
        $validation = Validator::make($request->only('subject', 'comment'), [
            'subject'   => 'required|string|max:30',
            'comment'   => 'required|string|max:250'
        ]);

        if ($validation->fails())
            return $this->errorResponse($validation->errors(), 'Failed validation', 422);

        try {
            
            Feedback::create([
                'user_id'   => auth()->user()->id,
                'subject'   => ucfirst($request->subject),
                'comment'   => $request->comment
            ]);

            return $this->successResponse(null, 'Thanks for your feedback');
            
        } catch (\Exception $e) {
            
            Log::error($e->getMessage());

            return $this->serverError();
        }
    }
}
