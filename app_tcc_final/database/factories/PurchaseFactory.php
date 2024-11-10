<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    protected $model = \App\Models\Purchase::class;

    public function definition()
    {
        return [
            'farm_id' => \App\Models\Farm::factory(),
            'buyer' => $this->faker->name(),
            'animal_quantity' => $this->faker->numberBetween(1, 100),
            'weight_per_animal' => $this->faker->randomFloat(2, 200, 500),
            'price' => $this->faker->randomFloat(2, 1000, 10000),
            'purchase_date' => $this->faker->date(),
            'is_paid' => $this->faker->boolean(),
        ];
    }
}
