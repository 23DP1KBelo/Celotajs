<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DestinationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'places_id' => $this->places_id,
            'created_at' => $this->created_at,
            'place' => new PlaceResource(
                $this->whenLoaded('place')
            ),
        ];
    }
}