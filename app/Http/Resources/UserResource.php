<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'                => $this->id,
            'firstname'         => $this->first_name,
            'lastname'          => $this->last_name,
            'phone'             => $this->phone,
            'email_verified'    => is_null($this->email_verified_at) ? false : true,
            'consent'           => $this->consent,
            'createdOn'         => $this->created_at->toDateTimeString()
        ];
    }
}
