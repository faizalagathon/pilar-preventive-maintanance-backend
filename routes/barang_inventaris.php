<?php

use App\Http\Controllers\BarangInventarisController;

Route::get('/barang', [BarangInventarisController::class, 'index']);
Route::get('/barang/getData/{id}', [BarangInventarisController::class, 'getData']);
Route::get('/barang/qr_code/isExists/{idBarang}', [BarangInventarisController::class, 'isQrCodeExists']);
Route::get('/barang/basedKategori/{idKategori}', [BarangInventarisController::class, 'basedKategori']);
Route::get('/barang/withoutKategori', [BarangInventarisController::class, 'withoutKategori']);
Route::get('/barang/count', [BarangInventarisController::class, 'count']);
Route::post('/barang/store', [BarangInventarisController::class, 'store']);
Route::get('/barang/show/{id}', [BarangInventarisController::class, 'show']);
Route::post('/barang/update/{id}', [BarangInventarisController::class, 'update']);
Route::delete('/barang/destroy/{id}', [BarangInventarisController::class, 'destroy']);
