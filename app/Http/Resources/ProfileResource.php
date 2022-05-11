<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'username'      => $this->username,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'phone'         => $this->phone,
            'about'         => $this->about,
            'country'       => $this->country,
            'state'         => $this->state,
            'city'          => $this->city,
            'address'       => $this->address,
            'postal_code'   => $this->postal_code,
            'facebook'      => $this->facebook,
            'instagram'     => $this->instagram,
            'twitter'       => $this->twitter,
            'tiktok'        => $this->tiktok,
            'photo'         => $this->user->getFirstMediaUrl('user-photos'),
            'cover_photo'   => $this->user->getFirstMediaUrl('cover-photos'),
        ];
    }
}
