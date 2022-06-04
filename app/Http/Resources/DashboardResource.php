<?php

namespace App\Http\Resources;

use App\Models\Experience;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $role = Experience::where('user_id', $this->id)
            ->orderBy('id', 'desc')
            ->pluck('title')->first();

        return [
            'role'          => $role,
            'fullname'      => $this->profile->first_name . ' ' . $this->profile->last_name,
            'address'       => $this->profile->address,
            'overview'      => $this->profile->about,
            'experiences'   => ExperienceResource::collection($this->whenLoaded('experiences')),
            'skills'        => SkillResource::collection($this->whenLoaded('skills')),
            'portfolios'    => PortfolioResource::collection($this->whenLoaded('portfolios'))
        ];
    }
}
