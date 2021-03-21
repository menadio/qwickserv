<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'user'          => $this->user->first_name . ' ' . $this->user->last_name,
            'business'      => $this->business->name,
            'fee'           => $this->feee,
            'status'        => strtolower($this->status->name),
            'reservedOn'    => $this->created_at->toDateTimeString()
        ];
    }
}
