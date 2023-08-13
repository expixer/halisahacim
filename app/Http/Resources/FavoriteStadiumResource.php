<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteStadiumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'stadium_id' => $this->stadium_id,
            'user_id' => $this->user_id,
            'stadium' => StadiumResource::make($this->whenLoaded('stadium')),
        ];
    }
}
