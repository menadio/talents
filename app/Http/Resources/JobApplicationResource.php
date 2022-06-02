<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationResource extends JsonResource
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
            'position_id' => $this->position_id,
            'user_id' => $this->user_id,
            'user' => $this->user->profile->first_name . ' ' . $this->user->profile->last_name,
            'location' => $this->user->profile->state,
            'status' => $this->status->name
        ];
    }
}
