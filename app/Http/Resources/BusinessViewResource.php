<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessViewResource extends JsonResource
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
            'name'          => $this->name,
            'description'   => $this->description,
            'address'       => $this->address,
            'phone'         => $this->phone,
            'logo'          => (! is_null($this->logo)) ? asset('storage') . '/' . $this->logo : null,
            'cover'         => (! is_null($this->cover)) ? asset('storage') . '/' . $this->cover : null,
            'category'      => $this->category->name,
            'rating'        => ($this->reviews->count() === 0) ? 0 : $this->reviews->avg('rating'),
            'no_of_reviews' => $this->reviews->count(),
            'reviews'       => ReviewResource::collection($this->whenLoaded('reviews')),
            'photos'        => BusinessPhotoResource::collection($this->whenLoaded('photos')),
            'services'      => ServiceResource::collection($this->whenLoaded('services')),
            'businessHours' => BusinessHourResource::collection($this->whenLoaded('businessHours')),
        ];
    }
}
