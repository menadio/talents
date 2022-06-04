<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'id'        => $this->id,
            'user_id'   => $this->user_id,
            'fullname'  => $this->user->profile->first_name . ' ' . $this->user->profile->last_name,
            'avatar'    => $this->user->getFirstMediaUrl('user-photos'),
            'post'      => $this->post,
            'image'     => $this->getFirstMediaUrl('post-images'),
            'comments'  => CommentResource::collection($this->whenLoaded('comments')),
            'created_at'=> $this->created_at,
        ];
    }
}
