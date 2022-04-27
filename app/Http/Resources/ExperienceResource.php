<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
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
            'id'             => $this->id,
            'user_id'        => $this->user_id,
            'title'          => $this->title,
            'employmentType' => $this->employmentType->name,
            'industry'       => $this->industry->name,
            'startDate'      => $this->start_date,
            'endDate'        => $this->end_date,
            'location'       => $this->location,
            'description'    => $this->description
        ];
    }
}
