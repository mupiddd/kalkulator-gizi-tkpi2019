<?php

use App\Http\Controllers\FoodIngredientController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FoodIngredientController::class, 'index'])->name('calculator.index');
Route::post('/login', [FoodIngredientController::class, 'login'])->name('calculator.login');
Route::post('/logout', [FoodIngredientController::class, 'logout'])->name('calculator.logout');
Route::match(['get', 'post'], '/calculate', [FoodIngredientController::class, 'calculate'])->name('calculator.calculate');