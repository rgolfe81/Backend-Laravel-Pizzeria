<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pizza')->insert(
            [
                [
                    'name' => "Carbonara",
                    'type' => "Classic",
                    'price' => "9"
                ],
                [
                    'name' => "Barbacoa",
                    'type' => "Classic",
                    'price' => "9"
                ],
                [
                    'name' => "Margarita",
                    'type' => "Slim",
                    'price' => "8.5"
                ],
                [
                    'name' => "Vegetal",
                    'type' => "Classic",
                    'price' => "9"
                ],
                [
                    'name' => "Hawaiana",
                    'type' => "Slim",
                    'price' => "8.5"  
                ],
            ]
        );
    }
}
