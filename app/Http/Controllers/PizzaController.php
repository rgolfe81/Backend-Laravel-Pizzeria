<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
    public function getAllPizzas()
    {
        try {
            $pizzas = Pizza::query()->get();
            Log::info("Get Pizzas");

            if ($pizzas->isEmpty()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "No pizzas found"
                    ],
                    500
                );
            }

            return [
                "success" => true,
                "data" => $pizzas
            ];
        } catch (\Throwable $th) {
            Log::error("GETTING PIZZAS: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error getting pizzas"
                ],
                500
            );
        }
    }

    public function createPizza(Request $request)
    {
        try {

            Log::info("Create Pizza");

            $validator = Validator::make($request->all(), [
                'name' => 'required | regex:/^[A-Za-z0-9]+$/',
                'type' => 'required',
                'price' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $name = $request->input('name');
            $type = $request->input('type');
            $price = $request->input('price');

            $pizza = new Pizza();
            $pizza->name = $name;
            $pizza->type = $type;
            $pizza->price = $price;
            $pizza->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Pizza created",
                    "data" => $pizza
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error("CREATING PIZZA: " . $th->getMessage());
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating pizza"
                ],
                500
            );
        }
    }
}
