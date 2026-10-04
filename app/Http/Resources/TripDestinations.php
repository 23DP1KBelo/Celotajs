<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripDestinations extends JsonResource
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
            'trip_id' => $this->trip_id,
            'destination_id' => $this->destination_id,
            'recommendations' => $this->recommendations,
            'destination' => new DestinationResource($this->whenLoaded('Destination')),
        ];
    }
}
