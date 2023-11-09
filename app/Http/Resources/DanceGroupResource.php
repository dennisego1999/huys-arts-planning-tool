<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\DanceGroup */
class DanceGroupResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => new MediaResource($this->getFirstMedia('dance-group-assets')),
            'members' => $this->members,
        ];
    }
}
