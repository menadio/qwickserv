<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
            'user_id'       => $this->user_id,
            'name'          => $this->name,
            'address'       => $this->address,
            'phone'         => $this->phone,
            'logo'          => (! is_null($this->logo)) ? asset('storage') . '/' . $this->logo : null,
            'cover'         => (! is_null($this->cover)) ? asset('storage') . '/' . $this->cover : null,
            'description'   => $this->descirption,
            'status'        => strtolower($this->status->name),
            'rating'        => ( $this->reviews->count() === 0 ) ? 0 : $this->reviews->avg('rating'),
            'views'         => $this->views_count,
            'searches'      => $this->search_count,
            'reviews'       => $this->reviews->count(),
            'totalBookings' => $this->bookings->count(),
            'created_at'    => $this->created_at->toDateString(),
            'category'      => ($this->category) ? $this->category->name : null,
            'services'      => ServiceResource::collection($this->whenLoaded('services')),
            'businessHours' => BusinessHourResource::collection($this->whenLoaded('businessHours')),
            'photos'        => BusinessPhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}
