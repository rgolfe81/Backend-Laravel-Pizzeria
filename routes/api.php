<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Users
Route::get('/users', [UserController::class, 'getUsers'] );
Route::post('/users', [UserController::class, 'postUsers'] );
Route::put('/users', [UserController::class, 'putUsers'] );
Route::delete('/users', [UserController::class, 'deleteUsers'] );

// Pizzas
Route::get('/pizzas', [PizzaController::class, 'getAllPizzas'] );
Route::post('/pizzas', [PizzaController::class, 'createPizza'] );
Route::put('/pizzas/{id}', [PizzaController::class, 'updatePizza'] );
Route::delete('/pizzas/{id}', [PizzaController::class, 'deletePizza'])->middleware('isAdmin');
Route::get('/pizzas/{id}', [PizzaController::class, 'getPizzaById']);
Route::get('/pizzas/reviews/{id}', [PizzaController::class, 'getPizzaByIdWithReviews']);
Route::get('/pizzas/ingredients/{id}', [PizzaController::class, 'getPizzaByIdWithIngredients']);
Route::post('/pizzas/add-ingredient/{id}', [PizzaController::class, 'addIngredientToPizzaId']);


// Ingredients
Route::get('/ingredients', [IngredientController::class, 'getAllIngredients'] );
Route::post('/ingredients', [IngredientController::class, 'createIngredient'] );
Route::put('/ingredients/{id}', [IngredientController::class, 'updateIngredient'] );
Route::delete('/ingredients/{id}', [IngredientController::class, 'deleteIngredient']);
Route::get('/ingredients/{id}', [IngredientController::class, 'getIngredientById']);

// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::group(
    ['middleware' => ['auth:sanctum', 'isAdmin']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

// Reviews
Route::group([
    'middleware' => 'auth:sanctum'
    ], function () {
        Route::post('/reviews', [ReviewController::class, 'createReview']);
});

// Email
Route::get('/send-email-example', [ExampleMailController::class, 'sendExampleEmail']);