<?php

use App\Http\Controllers\AvailableMoneyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

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

// Login

Route::get('register', [RegisterController::class, 'index'])->name('register');
Route::post('register', [RegisterController::class, 'store']);

Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::delete('logout/{id}', [LoginController::class, 'destroy']);

Route::middleware('auth')->group(function () {

    // Principal
    Route::get('/', [FinanceController::class, 'index']);

    // Entradas
    Route::any('entrada/search', [AvailableMoneyController::class, 'search']);
    Route::get('entrada', [AvailableMoneyController::class, 'index']);
    Route::get('entrada/create', [AvailableMoneyController::class, 'create']);
    Route::post('entrada', [AvailableMoneyController::class, 'store']);
    Route::get('entrada/{id}/edit', [AvailableMoneyController::class, 'edit']);
    Route::put('entrada/{id}', [AvailableMoneyController::class, 'update']);
    Route::delete('entrada/{id}', [AvailableMoneyController::class, 'destroy']);

    // Despesas
    Route::any('despesa/search', [FinanceController::class, 'search']);
    Route::get('despesa', [FinanceController::class, 'spentMoney']);
    Route::get('despesa/create', [FinanceController::class, 'create']);
    Route::post('despesa', [FinanceController::class, 'store']);
    Route::get('despesa/{id}/edit', [FinanceController::class, 'edit']);
    Route::put('despesa/{id}', [FinanceController::class, 'update']);
    Route::get('despesa/{id}/modal', [FinanceController::class, 'showModal']);
    Route::delete('despesa/{id}', [FinanceController::class, 'destroy']);

    // Categoria
    Route::any('categoria/search', [CategoryController::class, 'search']);
    Route::get('categoria', [CategoryController::class, 'index']);
    Route::get('categoria/create', [CategoryController::class, 'create']);
    Route::post('categoria', [CategoryController::class, 'store']);
    Route::get('categoria/{id}/edit', [CategoryController::class, 'edit']);
    Route::put('categoria/{id}', [CategoryController::class, 'update']);
    Route::delete('categoria/{id}', [CategoryController::class, 'destroy']);
});
