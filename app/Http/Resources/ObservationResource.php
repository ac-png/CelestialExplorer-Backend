<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ObservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'user_id' => $this->user_id,
            'celestial_body_id' => $this->celestial_body_id,
            'date' => $this->date,
            'time' => $this->time,
            'sky_conditions' => $this->sky_conditions,
            'description' => $this->description,
            'rating' => $this->rating,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
