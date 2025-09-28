<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SaleController;

Route::resource('sales', SaleController::class)->only(['index', 'create', 'store', 'destroy']);
Route::get('sales/trash', [SaleController::class, 'trash'])->name('sales.trash');
Route::post('sales/{id}/restore', [SaleController::class, 'restore'])->name('sales.restore');
Route::get('products/{id}/price', [SaleController::class, 'getProductPrice'])->name('products.price');
