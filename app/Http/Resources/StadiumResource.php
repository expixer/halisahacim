<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StadiumResource extends JsonResource
{
    public static $wrap = 'stadium';

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'firm_id' => $this->firm_id,
            'description' => $this->description,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
            'daytime_start' => $this->daytime_start,
            'nighttime_start' => $this->nighttime_start,
            'nighttime_end' => $this->nighttime_end,
            'daytime_price' => $this->daytime_price,
            'nighttime_price' => $this->nighttime_price,
            'recording' => $this->recording,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
        ];
    }

    public function with($request)
    {
        return ['status' => 'success'];
    }
}
