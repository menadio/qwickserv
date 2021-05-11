<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'opens_at'  => (! is_null($this->opens_at)) ? Carbon::parse($this->opens_at)->format('H:i') : null,
            'closes_at' => (! is_null($this->closes_at)) ? Carbon::parse($this->closes_at)->format('H:i') : null
        ];
    }
}
