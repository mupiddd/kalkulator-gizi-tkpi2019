<?php

use App\Http\Controllers\FoodIngredientController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FoodIngredientController::class, 'index'])->name('calculator.index');
Route::post('/calculate', [FoodIngredientController::class, 'calculate'])->name('calculator.calculate');