<?php

namespace App\Http\Resources;

use App\Models\Experience;
use Illuminate\Http\Resources\Json\JsonResource;

class TalentResource extends JsonResource
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
            'id'        => $this->id,
            'fullname'  => $this->profile->first_name . ' ' . $this->profile->last_name,
            'role'      => $role,
            'photo'     => $this->getFirstMediaUrl('user-photos'),
        ];
    }
}
