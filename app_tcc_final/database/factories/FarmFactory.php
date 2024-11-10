<?php

namespace Database\Factories;

use App\Enums\FarmTypeEnum;
use App\Models\Farm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farm>
 */
class FarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Farm::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'owner' => $this->faker->name(),
            'location' => $this->faker->address(),
            'type' => $this->faker->randomElement([FarmTypeEnum::HEADQUARTERS, FarmTypeEnum::RENTED]),
            'animal_quantity' => $this->faker->numberBetween(0, 200),
            'status' => $this->faker->boolean(100), // 80% chance de estar ativa
            'user_id' => User::factory(),
        ];
    }
}
