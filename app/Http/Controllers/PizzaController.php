<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
                'type' => [
                    'required',
                    Rule::in(['Slim', 'Classic', 'Original'])
                ],
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


    public function updatePizza(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'regex:/^[A-Za-z0-9]+$/',
                'type' => [
                    Rule::in(['Slim', 'Classic', 'Original']),
                ],
                'price' => 'numeric',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }

            $pizza = Pizza::find($id);

            if (!$pizza) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Pizza doesn't exists",
                    ],
                    404
                );
            }

            $name = $request->input('name');
            $type = $request->input('type');
            $price = $request->input('price');

            if (isset($name)) {
                $pizza->name = $request->input('name');
            }

            if (isset($type)) {
                $pizza->type = $request->input('type');
            }

            if (isset($price)) {
                $pizza->price = $request->input('price');
            }

            $pizza->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Pizza updated",
                    "data" => $pizza
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

    public function deletePizza(Request $request, $id)
    {
        try {

            $pizza = Pizza::find($id);
            if (!$pizza) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Pizza doesn't exists",
                    ],
                    404
                );
            }

            Pizza::destroy($id);

            // otra manera de hacerlo
            // Pizza::query()->where('id', $id)->where('is_active', 0)->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Pizza deleted"
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

    public function getPizzaById(Request $request, $id)
    {
        try {
            $pizza = Pizza::query()->find($id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Get Pizza successfully",
                    "data" => [
                        'id' => $pizza->id,
                        'name' => $pizza->name,
                        'type' => $pizza->type,
                        'price' => $pizza->price
                    ]
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

    public function getPizzaByIdWithReviews(Request $request, $id)
    {
        // ToDo manejo de errores
        try {
            // $pizzaByIdWithReviews = Pizza::query()->find($id)->reviews;

            $pizzaByIdWithReviews = Pizza::with(['reviews', 'reviews.user'])->find($id);

            return [
                "success" => true,
                "data" => $pizzaByIdWithReviews
            ];
        } catch (\Throwable $th) {
            Log::error('Error retrieving pizza with reviews: '.$th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => $th->getMessage()
                ],
                500
            );
        }
    }
    public function getPizzaByIdWithIngredients(Request $request, $id)
    {
        try {
            $pizzaWithIngredients = Pizza::query()->find($id);

            $pizzaWithIngredients->ingredients;

            return response()->json(
                [
                    "success" => true,
                    "data" => $pizzaWithIngredients
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error('Error retrieving pizza with ingredients: ' . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => 'Error retrieving pizza with ingredients'
                ],
                500
            );
        }
    }

    public function addIngredientToPizzaId(Request $request, $id)
    {
        try {
            $ingredientId = $request->input('ingredient_id');

            // $pizza = DB::table('ingredient_pizza')->insert(
            //     [
            //         'ingredient_id' => $ingredientId,
            //         'pizza_id' => $id
            //     ]
            // );

            $pizza = Pizza::find($id); 

            if (!$pizza) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Pizza 404 not found"
                    ],
                    404
                );
            }

            $pizza->ingredients()->attach($ingredientId);
            $pizza->ingredients;

            return response()->json(
                [
                    "success" => true,
                    "data" => $pizza
                ],
                200
            );
        } catch (\Throwable $th) {
            Log::error('Error adding ingredient to pizza: ' . $th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => 'Error adding ingredient to pizza'
                ],
                500
            );
        }
    }
}
