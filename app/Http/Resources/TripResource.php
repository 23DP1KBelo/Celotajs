<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TripDestinationResource;

class TripResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => $this->user_id,
            'date_form' => $this->date_from,
            'date_till' => $this->date_till,
            'budget' => $this->budget,
            'status' => $this->status,
            'category' => $this->category,
            'image' => $this->image,
            'trip_destinations' => TripDestinationResource::collection( $this->whenLoaded('tripDestinations')),
        ];
    }
}
