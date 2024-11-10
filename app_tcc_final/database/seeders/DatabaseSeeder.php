<?php

namespace Database\Seeders;

use App\Models\Birth;
use App\Models\Death;
use App\Models\Expense;
use App\Models\Farm;
use App\Models\Purchase;
use App\Models\Rentals;
use App\Models\Sale;
use App\Models\Transfer;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory()->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Farm::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);

        Rentals::factory(1)->create();
        Transfer::factory(1)->create();
        Purchase::factory(5)->create();
        Sale::factory(10)->create();
        Death::factory(1)->create();
        Birth::factory(10)->create();
        Expense::factory(10)->create();
    }
}