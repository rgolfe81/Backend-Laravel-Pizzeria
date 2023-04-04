<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function createIngredient(Request $request)
    {
        try {

            Log::info("Create Ingredient");

            $validator = Validator::make($request->all(), [
                'name' => 'required | regex:/^[A-Za-z0-9]+$/',
                'type' => 'required | regex:/^[A-Za-z0-9]+$/',
                'quantity' => 'required | numeric',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $name = $request->input('name');
            $type = $request->input('type');
            $quantity = $request->input('quantity');

            $ingredient = new Ingredient();
            $ingredient->name = $name;
            $ingredient->type = $type;
            $ingredient->quantity = $quantity;
            $ingredient->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Ingredient created",
                    "data" => $ingredient
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("CREATING INGREDIENT: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating ingredient"
                ],
                500
            );
        }
    }

    public function updateIngredient(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required | regex:/^[A-Za-z0-9]+$/',
                'type' => 'required | regex:/^[A-Za-z0-9]+$/',
                'quantity' => 'required | numeric',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $ingredient = Ingredient::find($id);

            if (!$ingredient) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Ingredient doesn't exists",
                    ],
                    404
                );
            }

            $name = $request->input('name');
            $type = $request->input('type');
            $quantity = $request->input('quantity');

            // $ingredient->name = $request->input('name');
            // $ingredient->type = $request->input('type');
            // $ingredient->quantity = $request->input('quantity');

            if (isset($name)) {
                $ingredient->name = $name;
            }

            if (isset($type)) {
                $ingredient->type = $type;
            }

            if (isset($price)) {
                $ingredient->quantity = $quantity;
            }

            $ingredient->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Ingredient updated",
                    "data" => $ingredient
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => $th->getMessage()
                ],
                500
            );
        }
    }

    public function deleteIngredient(Request $request, $id)
    {
        try {

            $ingredient = Ingredient::find($id);
            if (!$ingredient) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Ingredient doesn't exists",
                    ],
                    404
                );
            }

            Ingredient::destroy($id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Ingredient deleted"
                ],
                200
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => $th->getMessage()
                ],
                500
            );
        }
    }

}
