<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\Destination;
use App\Models\TripDestination;
use Illuminate\Database\Seeder;

class TripDestinationSeeder extends Seeder
{
    public function run(): void
    {
        $trips = Trip::all();
        $destinations = Destination::all();

        foreach ($trips as $trip) {
            // Katram trip izvēlas 1-3 nejaušus galamērķus
            $count = rand(1, 3);

            $selectedDestinations = $destinations
                ->shuffle()
                ->take($count);

            foreach ($selectedDestinations as $destination) {
                TripDestination::create([
                    'trip_id' => $trip->id,
                    'destination_id' => $destination->id,
                    'recommendations' => fake()->boolean(),
                ]);
            }
        }
    }
}
