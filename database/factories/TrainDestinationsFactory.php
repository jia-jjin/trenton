<?php

namespace Database\Factories;

use App\Models\Destination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainDestinations>
 */
class TrainDestinationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "train_id" => rand(3,4),
            "destination_id" => fake()->unique()->numberBetween(1,count(Destination::all()) -1),
            "arrival_time" => fake()->time('H:i'),
        ];
    }
}
