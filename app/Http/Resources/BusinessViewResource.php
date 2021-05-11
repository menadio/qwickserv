<?php

namespace App\Http\Resources;

use App\Models\BusinessHour;
use App\Http\Resources\BusinessHourResource;
use App\Models\WeekDay;
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
        $day = now()->englishDayOfWeek;
        $weekday = WeekDay::where('name', $day)->pluck('id')->first();
        $currentTime = now()->format('H:i');
        $businessHour = BusinessHour::where([
            ['business_id', $this->id],
            ['week_day_id', $weekday],
        ])->first();

        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'address'       => $this->address,
            'phone'         => $this->phone,
            'logo'          => (! is_null($this->logo)) ? asset('storage') . '/' . $this->logo : null,
            'cover'         => (! is_null($this->cover)) ? asset('storage') . '/' . $this->cover : null,
            'category'      => $this->category->name,
            'services'      => $this->services,
            'openNow'       => ($currentTime >= $businessHour->opens_at && $currentTime <= $businessHour->closes_at) ? true : false,
            'businessHour'  => new BusinessHourResource($businessHour),
            'rating'        => ($this->reviews->count() === 0) ? 0 : $this->reviews->avg('rating'),
            'no_of_reviews' => $this->reviews->count(),
            'reviews'       => ReviewResource::collection($this->whenLoaded('reviews')),
            'photos'        => BusinessPhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}
