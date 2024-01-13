<?php

use App\Http\Controllers\BarangInventarisController;

Route::get('/barang', [BarangInventarisController::class, 'index']);
Route::post('/barang/store', [BarangInventarisController::class, 'store']);
Route::get('/barang/show/{id}', [BarangInventarisController::class, 'show']);
Route::post('/barang/update/{id}', [BarangInventarisController::class, 'update']);
Route::delete('/barang/destroy/{id}', [BarangInventarisController::class, 'destroy']);
