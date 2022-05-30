<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PositionResource extends JsonResource
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
            'salary' => $this->salary,
            'location' => $this->location,
            'description' => $this->description,
            'open' => $this->open,
            'status' => $this->status->name,
            'category' => $this->category->name,
            'employmentType' => $this->employmentType->name,
            'createdAt' => $this->created_at
        ];
    }
}
