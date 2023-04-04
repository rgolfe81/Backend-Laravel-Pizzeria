<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(30)->create();
        $this->call([
            PizzaSeeder::class,
        ]);
        $this->call([
            IngredientSeeder::class,
        ]);
        \App\Models\Review::factory(50)->create();
    }
}
