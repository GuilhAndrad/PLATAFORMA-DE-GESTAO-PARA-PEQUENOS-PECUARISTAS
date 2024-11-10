<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rental>
 */
class RentalsFactory extends Factory
{
    protected $model = \App\Models\Rentals::class;

    public function definition()
    {
        return [
            'farm_id' => \App\Models\Farm::factory(),
            'animal_quantity' => $this->faker->numberBetween(1, 100),
            'price_per_head' => $this->faker->randomFloat(2, 100, 1000),
            'location' => $this->faker->city(),
            'rental_duration_days' => $this->faker->numberBetween(1, 365),
            'returned' => $this->faker->boolean(),
        ];
    }
}
