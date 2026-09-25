<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'budget' => fake()->randomFloat(2, 100, 5000),
            'date_from' => fake()->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'date_till' => fake()->dateTimeBetween('+2 days', '+1 year')->format('Y-m-d'),
            'status' => fake()->randomElement(['visited', 'unvisited']),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement(['rest', 'nature', 'adventure']),
            'image' => null,
        ];
    }
}
