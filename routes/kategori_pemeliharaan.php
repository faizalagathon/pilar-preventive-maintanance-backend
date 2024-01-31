<?php

use App\Http\Controllers\KategoriPemeliharaanController;

// use Illuminate\Routing\Route;

Route::get('/pemeliharaan/kategori', [KategoriPemeliharaanController::class, 'index']);
Route::get('/pemeliharaan/kategori/basedBarang/{id}', [KategoriPemeliharaanController::class, 'basedBarang']);
Route::get('/pemeliharaan/kategori/count', [KategoriPemeliharaanController::class, 'count']);
Route::get('/pemeliharaan/kategori/show/{id}', [KategoriPemeliharaanController::class, 'show']);
Route::post('/pemeliharaan/kategori/create', [KategoriPemeliharaanController::class, 'store']);
Route::post('/pemeliharaan/kategori/edit/{id}', [KategoriPemeliharaanController::class, 'update']);
Route::delete('/pemeliharaan/kategori/delete/{id}', [KategoriPemeliharaanController::class, 'destroy']);

