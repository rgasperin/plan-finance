<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [FinanceController::class, 'index']);
Route::get('entradas', [FinanceController::class, 'index']);
Route::get('despesas', [FinanceController::class, 'index']);



// Categoria
Route::get('categoria', [CategoryController::class, 'index']);
Route::get('categoria/create', [CategoryController::class, 'create']);
Route::post('categoria', [CategoryController::class, 'store']);
Route::get('categoria/{id}/edit', [CategoryController::class, 'edit']);
Route::put('categoria/{id}', [CategoryController::class, 'update']);
Route::delete('categoria/{id}', [CategoryController::class, 'destroy']);