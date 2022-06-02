<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'title' => $this->title,
            'category' => $this->eventCategory->name,
            'location' => $this->location,
            'date' => $this->date,
            'time' => $this->time,
            'description' => $this->description,
            'event_type' => $this->eventType->name,
            'price' => $this->price,
            'statue' => $this->status->name
        ];
    }
}
