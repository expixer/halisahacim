<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class StadiumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $favorite = $this->favoriteStadiums()->where('user_id', auth()->id());

        return [
            'id' => $this->id,
            'name' => $this->name,
            //            'firm_id' => $this->firm_id,
            'description' => $this->description,
            'address' => $this->address,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'phone' => $this->phone,
            'email' => $this->email,
            'website' => $this->website,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'images' => $this->whenLoaded('images'),
            'opening_time' => $this->hourFormat($this->opening_time),
            'closing_time' => $this->hourFormat($this->closing_time),
            'daytime_start' => $this->hourFormat($this->daytime_start),
            'nighttime_start' => $this->hourFormat($this->nighttime_start),
            'nighttime_end' => $this->hourFormat($this->nighttime_end),
            'daytime_price' => $this->daytime_price,
            'nighttime_price' => $this->nighttime_price,
            'recording' => $this->recording,
            'firm' => FirmResource::make($this->whenLoaded('firm')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'is_favorite' => $favorite->exists(),
            'favorite_id' => $favorite->exists() ? $favorite->first()->id : 0,
            'created_at' => (string) $this->created_at,
        ];
    }

    private function hourFormat($hour)
    {
        return Carbon::createFromFormat('H:i:s', $hour)->format('H:i');
    }

    public function with($request)
    {
        return ['status' => 'success'];
    }
}
