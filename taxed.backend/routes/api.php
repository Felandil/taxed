<?php

use App\Http\Controllers\API\AssetController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('assets')->group(function () {
    Route::get('/{id}', [AssetController::class, 'get'])->name('asset.get');
    Route::get('/', [AssetController::class, 'getAll']);
    Route::post('/', [AssetController::class, 'add']);

    Route::get('/by-category/{categoryId}', [AssetController::class, 'getByCategory'])->name('asset.byCategory');
});

Route::prefix('categories')->group(function () {
    Route::get('/{id}', [CategoryController::class, 'get'])->name('category.get');
    Route::get('/', [CategoryController::class, 'getAll'])->name('category.getAll');
});