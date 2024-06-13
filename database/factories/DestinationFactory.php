<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as FakerGenerator;
use Faker\Provider\ms_MY\Address;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $faker = new FakerGenerator();
        $faker->addProvider(new Address($faker));
        return [
            'destination' => $faker->unique()->township(),
        ];
    }
}
