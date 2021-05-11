<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        return [
            'id'                => $this->id,
            'firstname'         => $this->first_name,
            'lastname'          => $this->last_name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'email_verified'    => is_null($this->email_verified_at) ? false : true,
            'gender'            => $this->gender,
            'profileImage'      => (! is_null($this->profile_image)) ? asset('storage') . '/' . $this->profile_image : null,
            'accountType'       => strtolower($this->accountType->name),
            'consent'           => $this->consent,
            'status'            => strtolower($this->status->name),
            'business'          => $this->business,
            'business'          => new BusinessResource($this->whenLoaded('business')),
            'createdOn'         => $this->created_at->toDateTimeString()
        ];
    }
}
