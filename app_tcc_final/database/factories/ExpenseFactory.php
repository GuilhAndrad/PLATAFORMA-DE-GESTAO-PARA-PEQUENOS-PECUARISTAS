<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    protected $model = \App\Models\Expense::class;

    public function definition()
    {
        return [
            'farm_id' => \App\Models\Farm::factory(),
            'item' => $this->faker->word(),
            'cost' => $this->faker->randomFloat(2, 100, 1000),
            'quantity' => $this->faker->numberBetween(1, 20),
            'expense_date' => $this->faker->date(),
            'notes' => $this->faker->sentence(),
        ];
    }
}
