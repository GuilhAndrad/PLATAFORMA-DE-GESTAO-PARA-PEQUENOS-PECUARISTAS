<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    protected $model = \App\Models\Transfer::class;

    public function definition()
    {
        return [
            'origin_farm_id' => \App\Models\Farm::factory(),
            'destination_farm_id' => \App\Models\Farm::factory(),
            'animal_quantity' => $this->faker->numberBetween(1, 100),
            'transfer_date' => $this->faker->date(),
        ];
    }
}
