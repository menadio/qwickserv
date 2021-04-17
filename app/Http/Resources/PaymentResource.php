<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'reference'     => $this->reference,
            'status'        => strtolower($this->status->name),
            'createdOn'     => $this->created_at->toDateTimeString()
        ];
    }
}
