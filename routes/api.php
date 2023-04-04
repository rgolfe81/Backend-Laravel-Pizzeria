<?php

use App\Http\Controllers\PizzaController;
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
Route::put('/pizzas{id}', [PizzaController::class, 'updatePizza'] );
Route::delete('/pizzas/{id}', [PizzaController::class, 'deletePizza']);
Route::get('/pizzas/{id}', [PizzaController::class, 'getPizzaById']);
