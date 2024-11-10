<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Birth>
 */
class BirthFactory extends Factory
{
    protected $model = \App\Models\Birth::class;

    public function definition()
    {
        return [
            'farm_id' => \App\Models\Farm::factory(),
            'birth_date' => $this->faker->date(),
            'animal_quantity' => $this->faker->numberBetween(1, 50),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'notes' => $this->faker->sentence(),
        ];
    }
}
