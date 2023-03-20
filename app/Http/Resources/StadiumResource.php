<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StadiumResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
//            'firm_id' => $this->firm_id,
            'description' => $this->description,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
            'daytime_start' => $this->daytime_start,
            'nighttime_start' => $this->nighttime_start,
            'nighttime_end' => $this->nighttime_end,
            'daytime_price' => $this->daytime_price,
            'nighttime_price' => $this->nighttime_price,
            'recording' => $this->recording,
            'firm' => FirmResource::make($this->whenLoaded('firm')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'created_at' => (string)$this->created_at,
        ];
    }

    public function with($request)
    {
        return ['status' => 'success'];
    }
}
