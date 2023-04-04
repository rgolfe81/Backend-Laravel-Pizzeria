<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredient')->insert(
            [
                [
                    'quantity' => "2",
                    'name' => "Tomate",
                    'type' => "Fruta",
                ],
                [
                    'quantity' => "1.5",
                    'name' => "Carne picada",
                    'type' => "Carne",
                ],
                [
                    'quantity' => "2",
                    'name' => "Queso",
                    'type' => "Lacteo",
                ],
                [
                    'quantity' => "1",
                    'name' => "Jamón",
                    'type' => "Carne",
                ],
                [
                    'quantity' => "4",
                    'name' => "Champiñon",
                    'type' => "Verdura",
                ],
                [
                    'quantity' => "2.5",
                    'name' => "Bacon",
                    'type' => "Carne",
                ],
            ]
        );
    }
}
