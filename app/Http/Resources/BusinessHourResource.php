<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessHourResource extends JsonResource
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
            'id'        => $this->id,
            'weekDay'   => $this->weekDay->name,
            'opens_at'  => $this->opens_at,
            'closes_at' => $this->closes_at
        ];
    }
}
