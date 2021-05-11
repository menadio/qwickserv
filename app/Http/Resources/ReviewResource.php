<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'customer'      => $this->user->first_name . ' ' . $this->user->last_name,
            'comment'       => $this->comment,
            'rating'        => $this->rating,
            'created_at'    => $this->created_at->toDateTimeString()
        ];
    }
}
