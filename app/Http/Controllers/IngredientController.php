<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IngredientController extends Controller
{
    public function getAllIngredients()
    {
        try {
            $ingredients = Ingredient::query()->get();
            Log::info("Get Ingredients");

            if ($ingredients->isEmpty()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "No ingredients found"
                    ],
                    500
                );
            }

            return [
                "success" => true,
                "data" => $ingredients
            ];
        } catch (\Throwable $th) {
            Log::error("GETTING INGREDIENTS: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting ingredients"
                ],
                500
            );
        }
    }
}
