<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Death>
 */
class DeathFactory extends Factory
{
    protected $model = \App\Models\Death::class;

    public function definition()
    {
        return [
            'farm_id' => \App\Models\Farm::factory(),
            'death_date' => $this->faker->date(),
            'animal_quantity' => $this->faker->numberBetween(1, 50),
            'cause' => $this->faker->word(),
            'notes' => $this->faker->sentence(),
        ];
    }
}
