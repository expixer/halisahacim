<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StadiumCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *N
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return StadiumResource::collection($this->collection);
    }
    public function with($request)
    {
        return [
            'status' => 'success',
            'count' => $this->collection->count()
        ];
    }
}
